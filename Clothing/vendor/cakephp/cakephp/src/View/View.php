<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\home;

use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Core\InstanceConfigTrait;
use Cake\Core\Plugin;
use Cake\Event\EventDispatcherInterface;
use Cake\Event\EventDispatcherTrait;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Log\LogTrait;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\home\Exception\MissingElementException;
use Cake\home\Exception\MissingLayoutException;
use Cake\home\Exception\MissingTemplateException;
use InvalidArgumentException;
use LogicException;
use RuntimeException;
use Throwable;

/**
 * home, the V in the MVC triad. home interacts with Helpers and home variables passed
 * in from the controller to render the results of the controller action. Often this is HTML,
 * but can also take the form of JSON, XML, PDF's or streaming files.
 *
 * CakePHP uses a two-step-home pattern. This means that the template content is rendered first,
 * and then inserted into the selected layout. This also means you can pass data from the template to the
 * layout using `$this->set()`
 *
 * home class supports using plugins as themes. You can set
 *
 * ```
 * public function beforeRender(\Cake\Event\EventInterface $event)
 * {
 *      $this->homeBuilder()->setTheme('SuperHot');
 * }
 * ```
 *
 * in your Controller to use plugin `SuperHot` as a theme. Eg. If current action
 * is PostsController::index() then home class will look for template file
 * `plugins/SuperHot/templates/Posts/index.php`. If a theme template
 * is not found for the current action the default app template file is used.
 *
 * @property \Cake\home\Helper\BreadcrumbsHelper $Breadcrumbs
 * @property \Cake\home\Helper\FlashHelper $Flash
 * @property \Cake\home\Helper\FormHelper $Form
 * @property \Cake\home\Helper\HtmlHelper $Html
 * @property \Cake\home\Helper\NumberHelper $Number
 * @property \Cake\home\Helper\PaginatorHelper $Paginator
 * @property \Cake\home\Helper\TextHelper $Text
 * @property \Cake\home\Helper\TimeHelper $Time
 * @property \Cake\home\Helper\UrlHelper $Url
 * @property \Cake\home\homeBlock $Blocks
 */
class home implements EventDispatcherInterface
{
    use CellTrait {
        cell as public;
    }
    use EventDispatcherTrait;
    use InstanceConfigTrait {
        getConfig as private _getConfig;
    }
    use LogTrait;

    /**
     * Helpers collection
     *
     * @var \Cake\home\HelperRegistry
     */
    protected $_helpers;

    /**
     * homeBlock instance.
     *
     * @var \Cake\home\homeBlock
     */
    protected $Blocks;

    /**
     * The name of the plugin.
     *
     * @var string|null
     */
    protected $plugin;

    /**
     * Name of the controller that created the home if any.
     *
     * @var string
     */
    protected $name = '';

    /**
     * An array of names of built-in helpers to include.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * The name of the subfolder containing templates for this home.
     *
     * @var string
     */
    protected $templatePath = '';

    /**
     * The name of the template file to render. The name specified
     * is the filename in `templates/<SubFolder>/` without the .php extension.
     *
     * @var string
     */
    protected $template;

    /**
     * The name of the layout file to render the template inside of. The name specified
     * is the filename of the layout in `templates/layout/` without the .php
     * extension.
     *
     * @var string
     */
    protected $layout = 'default';

    /**
     * The name of the layouts subfolder containing layouts for this home.
     *
     * @var string
     */
    protected $layoutPath = '';

    /**
     * Turns on or off CakePHP's conventional mode of applying layout files. On by default.
     * Setting to off means that layouts will not be automatically applied to rendered templates.
     *
     * @var bool
     */
    protected $autoLayout = true;

    /**
     * An array of variables
     *
     * @var array
     */
    protected $homeVars = [];

    /**
     * File extension. Defaults to ".php".
     *
     * @var string
     */
    protected $_ext = '.php';

    /**
     * Sub-directory for this template file. This is often used for extension based routing.
     * Eg. With an `xml` extension, $subDir would be `xml/`
     *
     * @var string
     */
    protected $subDir = '';

    /**
     * The home theme to use.
     *
     * @var string|null
     */
    protected $theme;

    /**
     * An instance of a \Cake\Http\ServerRequest object that contains information about the current request.
     * This object contains all the information about a request and several methods for reading
     * additional information about the request.
     *
     * @var \Cake\Http\ServerRequest
     */
    protected $request;

    /**
     * Reference to the Response object
     *
     * @var \Cake\Http\Response
     */
    protected $response;

    /**
     * The Cache configuration home will use to store cached elements. Changing this will change
     * the default configuration elements are stored under. You can also choose a cache config
     * per element.
     *
     * @var string
     * @see \Cake\home\home::element()
     */
    protected $elementCache = 'default';

    /**
     * List of variables to collect from the associated controller.
     *
     * @var string[]
     */
    protected $_passedVars = [
        'homeVars', 'autoLayout', 'helpers', 'template', 'layout', 'name', 'theme',
        'layoutPath', 'templatePath', 'plugin',
    ];

    /**
     * Default custom config options.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    /**
     * Holds an array of paths.
     *
     * @var string[]
     */
    protected $_paths = [];

    /**
     * Holds an array of plugin paths.
     *
     * @var string[][]
     */
    protected $_pathsForPlugin = [];

    /**
     * The names of homes and their parents used with home::extend();
     *
     * @var string[]
     */
    protected $_parents = [];

    /**
     * The currently rendering home file. Used for resolving parent files.
     *
     * @var string
     */
    protected $_current;

    /**
     * Currently rendering an element. Used for finding parent fragments
     * for elements.
     *
     * @var string
     */
    protected $_currentType = '';

    /**
     * Content stack, used for nested templates that all use home::extend();
     *
     * @var string[]
     */
    protected $_stack = [];

    /**
     * homeBlock class.
     *
     * @var string
     * @psalm-var class-string<\Cake\home\homeBlock>
     */
    protected $_homeBlockClass = homeBlock::class;

    /**
     * Constant for home file type 'template'.
     *
     * @var string
     */
    public const TYPE_TEMPLATE = 'template';

    /**
     * Constant for home file type 'element'
     *
     * @var string
     */
    public const TYPE_ELEMENT = 'element';

    /**
     * Constant for home file type 'layout'
     *
     * @var string
     */
    public const TYPE_LAYOUT = 'layout';

    /**
     * Constant for type used for App::path().
     *
     * @var string
     */
    public const NAME_TEMPLATE = 'templates';

    /**
     * Constant for folder name containing files for overriding plugin templates.
     *
     * @var string
     */
    public const PLUGIN_TEMPLATE_FOLDER = 'plugin';

    /**
     * Constructor
     *
     * @param \Cake\Http\ServerRequest|null $request Request instance.
     * @param \Cake\Http\Response|null $response Response instance.
     * @param \Cake\Event\EventManager|null $eventManager Event manager instance.
     * @param array $homeOptions home options. See home::$_passedVars for list of
     *   options which get set as class properties.
     */
    public function __construct(
        ?ServerRequest $request = null,
        ?Response $response = null,
        ?EventManager $eventManager = null,
        array $homeOptions = []
    ) {
        foreach ($this->_passedVars as $var) {
            if (isset($homeOptions[$var])) {
                $this->{$var} = $homeOptions[$var];
            }
        }
        $this->setConfig(array_diff_key(
            $homeOptions,
            array_flip($this->_passedVars)
        ));

        if ($eventManager !== null) {
            $this->setEventManager($eventManager);
        }
        if ($request === null) {
            $request = Router::getRequest() ?: new ServerRequest(['base' => '', 'url' => '', 'webroot' => '/']);
        }
        $this->request = $request;
        $this->response = $response ?: new Response();
        $this->Blocks = new $this->_homeBlockClass();
        $this->initialize();
        $this->loadHelpers();
    }

    /**
     * Initialization hook method.
     *
     * Properties like $helpers etc. cannot be initialized statically in your custom
     * home class as they are overwritten by values from controller in constructor.
     * So this method allows you to manipulate them as required after home instance
     * is constructed.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Gets the request instance.
     *
     * @return \Cake\Http\ServerRequest
     * @since 3.7.0
     */
    public function getRequest(): ServerRequest
    {
        return $this->request;
    }

    /**
     * Sets the request objects and configures a number of controller properties
     * based on the contents of the request. The properties that get set are:
     *
     * - $this->request - To the $request parameter
     * - $this->plugin - To the value returned by $request->getParam('plugin')
     *
     * @param \Cake\Http\ServerRequest $request Request instance.
     * @return $this
     */
    public function setRequest(ServerRequest $request)
    {
        $this->request = $request;
        $this->plugin = $request->getParam('plugin');

        return $this;
    }

    /**
     * Gets the response instance.
     *
     * @return \Cake\Http\Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Sets the response instance.
     *
     * @param \Cake\Http\Response $response Response instance.
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get path for templates files.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * Set path for templates files.
     *
     * @param string $path Path for template files.
     * @return $this
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;

        return $this;
    }

    /**
     * Get path for layout files.
     *
     * @return string
     */
    public function getLayoutPath(): string
    {
        return $this->layoutPath;
    }

    /**
     * Set path for layout files.
     *
     * @param string $path Path for layout files.
     * @return $this
     */
    public function setLayoutPath(string $path)
    {
        $this->layoutPath = $path;

        return $this;
    }

    /**
     * Returns if CakePHP's conventional mode of applying layout files is enabled.
     * Disabled means that layouts will not be automatically applied to rendered homes.
     *
     * @return bool
     */
    public function isAutoLayoutEnabled(): bool
    {
        return $this->autoLayout;
    }

    /**
     * Turns on or off CakePHP's conventional mode of applying layout files.
     * On by default. Setting to off means that layouts will not be
     * automatically applied to rendered homes.
     *
     * @param bool $enable Boolean to turn on/off.
     * @return $this
     */
    public function enableAutoLayout(bool $enable = true)
    {
        $this->autoLayout = $enable;

        return $this;
    }

    /**
     * Turns off CakePHP's conventional mode of applying layout files.
     * Layouts will not be automatically applied to rendered homes.
     *
     * @return $this
     */
    public function disableAutoLayout()
    {
        $this->autoLayout = false;

        return $this;
    }

    /**
     * Get the current home theme.
     *
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * Set the home theme to use.
     *
     * @param string|null $theme Theme name.
     * @return $this
     */
    public function setTheme(?string $theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get the name of the template file to render. The name specified is the
     * filename in `templates/<SubFolder>/` without the .php extension.
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Set the name of the template file to render. The name specified is the
     * filename in `templates/<SubFolder>/` without the .php extension.
     *
     * @param string $name Template file name to set.
     * @return $this
     */
    public function setTemplate(string $name)
    {
        $this->template = $name;

        return $this;
    }

    /**
     * Get the name of the layout file to render the template inside of.
     * The name specified is the filename of the layout in `templates/layout/`
     * without the .php extension.
     *
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * Set the name of the layout file to render the template inside of.
     * The name specified is the filename of the layout in `templates/layout/`
     * without the .php extension.
     *
     * @param string $name Layout file name to set.
     * @return $this
     */
    public function setLayout(string $name)
    {
        $this->layout = $name;

        return $this;
    }

    /**
     * Get config value.
     *
     * Currently if config is not set it fallbacks to checking corresponding
     * home var with underscore prefix. Using underscore prefixed special home
     * vars is deprecated and this fallback will be removed in CakePHP 4.1.0.
     *
     * @param string|null $key The key to get or null for the whole config.
     * @param mixed $default The return value when the key does not exist.
     * @return mixed Config value being read.
     * @psalm-suppress PossiblyNullArgument
     */
    public function getConfig(?string $key = null, $default = null)
    {
        $value = $this->_getConfig($key);

        if ($value !== null) {
            return $value;
        }

        if (isset($this->homeVars["_{$key}"])) {
            deprecationWarning(sprintf(
                'Setting special home var "_%s" is deprecated. Use homeBuilder::setOption(\'%s\', $value) instead.',
                $key,
                $key
            ));

            return $this->homeVars["_{$key}"];
        }

        return $default;
    }

    /**
     * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
     *
     * This realizes the concept of Elements, (or "partial layouts") and the $params array is used to send
     * data to be used in the element. Elements can be cached improving performance by using the `cache` option.
     *
     * @param string $name Name of template file in the `templates/element/` folder,
     *   or `MyPlugin.template` to use the template element from MyPlugin. If the element
     *   is not found in the plugin, the normal home path cascade will be searched.
     * @param array $data Array of data to be made available to the rendered home (i.e. the Element)
     * @param array $options Array of options. Possible keys are:
     *
     * - `cache` - Can either be `true`, to enable caching using the config in home::$elementCache. Or an array
     *   If an array, the following keys can be used:
     *
     *   - `config` - Used to store the cached element in a custom cache configuration.
     *   - `key` - Used to define the key used in the Cache::write(). It will be prefixed with `element_`
     *
     * - `callbacks` - Set to true to fire beforeRender and afterRender helper callbacks for this element.
     *   Defaults to false.
     * - `ignoreMissing` - Used to allow missing elements. Set to true to not throw exceptions.
     * - `plugin` - setting to false will force to use the application's element from plugin templates, when the
     *   plugin has element with same name. Defaults to true
     * @return string Rendered Element
     * @throws \Cake\home\Exception\MissingElementException When an element is missing and `ignoreMissing`
     *   is false.
     */
    public function element(string $name, array $data = [], array $options = []): string
    {
        $options += ['callbacks' => false, 'cache' => null, 'plugin' => null];
        if (isset($options['cache'])) {
            $options['cache'] = $this->_elementCache($name, $data, $options);
        }

        $pluginCheck = $options['plugin'] !== false;
        $file = $this->_getElementFileName($name, $pluginCheck);
        if ($file && $options['cache']) {
            return $this->cache(function () use ($file, $data, $options): void {
                echo $this->_renderElement($file, $data, $options);
            }, $options['cache']);
        }
        if ($file) {
            return $this->_renderElement($file, $data, $options);
        }

        if (empty($options['ignoreMissing'])) {
            [$plugin, $elementName] = $this->pluginSplit($name, $pluginCheck);
            $paths = iterator_to_array($this->getElementPaths($plugin));
            throw new MissingElementException([$name . $this->_ext, $elementName . $this->_ext], $paths);
        }

        return '';
    }

    /**
     * Create a cached block of home logic.
     *
     * This allows you to cache a block of home output into the cache
     * defined in `elementCache`.
     *
     * This method will attempt to read the cache first. If the cache
     * is empty, the $block will be run and the output stored.
     *
     * @param callable $block The block of code that you want to cache the output of.
     * @param array $options The options defining the cache key etc.
     * @return string The rendered content.
     * @throws \RuntimeException When $options is lacking a 'key' option.
     */
    public function cache(callable $block, array $options = []): string
    {
        $options += ['key' => '', 'config' => $this->elementCache];
        if (empty($options['key'])) {
            throw new RuntimeException('Cannot cache content with an empty key');
        }
        $result = Cache::read($options['key'], $options['config']);
        if ($result) {
            return $result;
        }

        $bufferLevel = ob_get_level();
        ob_start();

        try {
            $block();
        } catch (Throwable $exception) {
            while (ob_get_level() > $bufferLevel) {
                ob_end_clean();
            }

            throw $exception;
        }

        $result = ob_get_clean();

        Cache::write($options['key'], $result, $options['config']);

        return $result;
    }

    /**
     * Checks if an element exists
     *
     * @param string $name Name of template file in the `templates/element/` folder,
     *   or `MyPlugin.template` to check the template element from MyPlugin. If the element
     *   is not found in the plugin, the normal home path cascade will be searched.
     * @return bool Success
     */
    public function elementExists(string $name): bool
    {
        return (bool)$this->_getElementFileName($name);
    }

    /**
     * Renders home for given template file and layout.
     *
     * Render triggers helper callbacks, which are fired before and after the template are rendered,
     * as well as before and after the layout. The helper callbacks are called:
     *
     * - `beforeRender`
     * - `afterRender`
     * - `beforeLayout`
     * - `afterLayout`
     *
     * If home::$autoLayout is set to `false`, the template will be returned bare.
     *
     * Template and layout names can point to plugin templates or layouts. Using the `Plugin.template` syntax
     * a plugin template/layout/ can be used instead of the app ones. If the chosen plugin is not found
     * the template will be located along the regular home path cascade.
     *
     * @param string|null $template Name of template file to use
     * @param string|false|null $layout Layout to use. False to disable.
     * @return string Rendered content.
     * @throws \Cake\Core\Exception\CakeException If there is an error in the home.
     * @triggers home.beforeRender $this, [$templateFileName]
     * @triggers home.afterRender $this, [$templateFileName]
     */
    public function render(?string $template = null, $layout = null): string
    {
        $defaultLayout = '';
        $defaultAutoLayout = null;
        if ($layout === false) {
            $defaultAutoLayout = $this->autoLayout;
            $this->autoLayout = false;
        } elseif ($layout !== null) {
            $defaultLayout = $this->layout;
            $this->layout = $layout;
        }

        $templateFileName = $this->_getTemplateFileName($template);
        $this->_currentType = static::TYPE_TEMPLATE;
        $this->dispatchEvent('home.beforeRender', [$templateFileName]);
        $this->Blocks->set('content', $this->_render($templateFileName));
        $this->dispatchEvent('home.afterRender', [$templateFileName]);

        if ($this->autoLayout) {
            if (empty($this->layout)) {
                throw new RuntimeException(
                    'home::$layout must be a non-empty string.' .
                    'To disable layout rendering use method home::disableAutoLayout() instead.'
                );
            }

            $this->Blocks->set('content', $this->renderLayout('', $this->layout));
        }
        if ($layout !== null) {
            $this->layout = $defaultLayout;
        }
        if ($defaultAutoLayout !== null) {
            $this->autoLayout = $defaultAutoLayout;
        }

        return $this->Blocks->get('content');
    }

    /**
     * Renders a layout. Returns output from _render().
     *
     * Several variables are created for use in layout.
     *
     * @param string $content Content to render in a template, wrapped by the surrounding layout.
     * @param string|null $layout Layout name
     * @return string Rendered output.
     * @throws \Cake\Core\Exception\CakeException if there is an error in the home.
     * @triggers home.beforeLayout $this, [$layoutFileName]
     * @triggers home.afterLayout $this, [$layoutFileName]
     */
    public function renderLayout(string $content, ?string $layout = null): string
    {
        $layoutFileName = $this->_getLayoutFileName($layout);

        if (!empty($content)) {
            $this->Blocks->set('content', $content);
        }

        $this->dispatchEvent('home.beforeLayout', [$layoutFileName]);

        $title = $this->Blocks->get('title');
        if ($title === '') {
            $title = Inflector::humanize(str_replace(DIRECTORY_SEPARATOR, '/', $this->templatePath));
            $this->Blocks->set('title', $title);
        }

        $this->_currentType = static::TYPE_LAYOUT;
        $this->Blocks->set('content', $this->_render($layoutFileName));

        $this->dispatchEvent('home.afterLayout', [$layoutFileName]);

        return $this->Blocks->get('content');
    }

    /**
     * Returns a list of variables available in the current home context
     *
     * @return string[] Array of the set home variable names.
     */
    public function getVars(): array
    {
        return array_keys($this->homeVars);
    }

    /**
     * Returns the contents of the given home variable.
     *
     * @param string $var The home var you want the contents of.
     * @param mixed $default The default/fallback content of $var.
     * @return mixed The content of the named var if its set, otherwise $default.
     */
    public function get(string $var, $default = null)
    {
        if (!isset($this->homeVars[$var])) {
            return $default;
        }

        return $this->homeVars[$var];
    }

    /**
     * Saves a variable or an associative array of variables for use inside a template.
     *
     * @param string|array $name A string or an array of data.
     * @param mixed $value Value in case $name is a string (which then works as the key).
     *   Unused if $name is an associative array, otherwise serves as the values to $name's keys.
     * @return $this
     * @throws \RuntimeException If the array combine operation failed.
     */
    public function set($name, $value = null)
    {
        if (is_array($name)) {
            if (is_array($value)) {
                $data = array_combine($name, $value);
                if ($data === false) {
                    throw new RuntimeException(
                        'Invalid data provided for array_combine() to work: Both $name and $value require same count.'
                    );
                }
            } else {
                $data = $name;
            }
        } else {
            $data = [$name => $value];
        }
        $this->homeVars = $data + $this->homeVars;

        return $this;
    }

    /**
     * Get the names of all the existing blocks.
     *
     * @return string[] An array containing the blocks.
     * @see \Cake\home\homeBlock::keys()
     */
    public function blocks(): array
    {
        return $this->Blocks->keys();
    }

    /**
     * Start capturing output for a 'block'
     *
     * You can use start on a block multiple times to
     * append or prepend content in a capture mode.
     *
     * ```
     * // Append content to an existing block.
     * $this->start('content');
     * echo $this->fetch('content');
     * echo 'Some new content';
     * $this->end();
     *
     * // Prepend content to an existing block
     * $this->start('content');
     * echo 'Some new content';
     * echo $this->fetch('content');
     * $this->end();
     * ```
     *
     * @param string $name The name of the block to capture for.
     * @return $this
     * @see \Cake\home\homeBlock::start()
     */
    public function start(string $name)
    {
        $this->Blocks->start($name);

        return $this;
    }

    /**
     * Append to an existing or new block.
     *
     * Appending to a new block will create the block.
     *
     * @param string $name Name of the block
     * @param mixed $value The content for the block. Value will be type cast
     *   to string.
     * @return $this
     * @see \Cake\home\homeBlock::concat()
     */
    public function append(string $name, $value = null)
    {
        $this->Blocks->concat($name, $value);

        return $this;
    }

    /**
     * Prepend to an existing or new block.
     *
     * Prepending to a new block will create the block.
     *
     * @param string $name Name of the block
     * @param mixed $value The content for the block. Value will be type cast
     *   to string.
     * @return $this
     * @see \Cake\home\homeBlock::concat()
     */
    public function prepend(string $name, $value)
    {
        $this->Blocks->concat($name, $value, homeBlock::PREPEND);

        return $this;
    }

    /**
     * Set the content for a block. This will overwrite any
     * existing content.
     *
     * @param string $name Name of the block
     * @param mixed $value The content for the block. Value will be type cast
     *   to string.
     * @return $this
     * @see \Cake\home\homeBlock::set()
     */
    public function assign(string $name, $value)
    {
        $this->Blocks->set($name, $value);

        return $this;
    }

    /**
     * Reset the content for a block. This will overwrite any
     * existing content.
     *
     * @param string $name Name of the block
     * @return $this
     * @see \Cake\home\homeBlock::set()
     */
    public function reset(string $name)
    {
        $this->assign($name, '');

        return $this;
    }

    /**
     * Fetch the content for a block. If a block is
     * empty or undefined '' will be returned.
     *
     * @param string $name Name of the block
     * @param string $default Default text
     * @return string The block content or $default if the block does not exist.
     * @see \Cake\home\homeBlock::get()
     */
    public function fetch(string $name, string $default = ''): string
    {
        return $this->Blocks->get($name, $default);
    }

    /**
     * End a capturing block. The compliment to home::start()
     *
     * @return $this
     * @see \Cake\home\homeBlock::end()
     */
    public function end()
    {
        $this->Blocks->end();

        return $this;
    }

    /**
     * Check if a block exists
     *
     * @param string $name Name of the block
     * @return bool
     */
    public function exists(string $name): bool
    {
        return $this->Blocks->exists($name);
    }

    /**
     * Provides template or element extension/inheritance. Templates can extends a
     * parent template and populate blocks in the parent template.
     *
     * @param string $name The template or element to 'extend' the current one with.
     * @return $this
     * @throws \LogicException when you extend a template with itself or make extend loops.
     * @throws \LogicException when you extend an element which doesn't exist
     */
    public function extend(string $name)
    {
        $type = $name[0] === '/' ? static::TYPE_TEMPLATE : $this->_currentType;
        switch ($type) {
            case static::TYPE_ELEMENT:
                $parent = $this->_getElementFileName($name);
                if (!$parent) {
                    [$plugin, $name] = $this->pluginSplit($name);
                    $paths = $this->_paths($plugin);
                    $defaultPath = $paths[0] . static::TYPE_ELEMENT . DIRECTORY_SEPARATOR;
                    throw new LogicException(sprintf(
                        'You cannot extend an element which does not exist (%s).',
                        $defaultPath . $name . $this->_ext
                    ));
                }
                break;
            case static::TYPE_LAYOUT:
                $parent = $this->_getLayoutFileName($name);
                break;
            default:
                $parent = $this->_getTemplateFileName($name);
        }

        if ($parent === $this->_current) {
            throw new LogicException('You cannot have templates extend themselves.');
        }
        if (isset($this->_parents[$parent]) && $this->_parents[$parent] === $this->_current) {
            throw new LogicException('You cannot have templates extend in a loop.');
        }
        $this->_parents[$this->_current] = $parent;

        return $this;
    }

    /**
     * Retrieve the current template type
     *
     * @return string
     */
    public function getCurrentType(): string
    {
        return $this->_currentType;
    }

    /**
     * Magic accessor for helpers.
     *
     * @param string $name Name of the attribute to get.
     * @return mixed
     */
    public function __get(string $name)
    {
        $registry = $this->helpers();
        if (isset($registry->{$name})) {
            $this->{$name} = $registry->{$name};

            return $registry->{$name};
        }
    }

    /**
     * Interact with the HelperRegistry to load all the helpers.
     *
     * @return $this
     */
    public function loadHelpers()
    {
        $registry = $this->helpers();
        $helpers = $registry->normalizeArray($this->helpers);
        foreach ($helpers as $properties) {
            $this->loadHelper($properties['class'], $properties['config']);
        }

        return $this;
    }

    /**
     * Renders and returns output for given template filename with its
     * array of data. Handles parent/extended templates.
     *
     * @param string $templateFile Filename of the template
     * @param array $data Data to include in rendered home. If empty the current
     *   home::$homeVars will be used.
     * @return string Rendered output
     * @throws \LogicException When a block is left open.
     * @triggers home.beforeRenderFile $this, [$templateFile]
     * @triggers home.afterRenderFile $this, [$templateFile, $content]
     */
    protected function _render(string $templateFile, array $data = []): string
    {
        if (empty($data)) {
            $data = $this->homeVars;
        }
        $this->_current = $templateFile;
        $initialBlocks = count($this->Blocks->unclosed());

        $this->dispatchEvent('home.beforeRenderFile', [$templateFile]);

        $content = $this->_evaluate($templateFile, $data);

        $afterEvent = $this->dispatchEvent('home.afterRenderFile', [$templateFile, $content]);
        if ($afterEvent->getResult() !== null) {
            $content = $afterEvent->getResult();
        }

        if (isset($this->_parents[$templateFile])) {
            $this->_stack[] = $this->fetch('content');
            $this->assign('content', $content);

            $content = $this->_render($this->_parents[$templateFile]);
            $this->assign('content', array_pop($this->_stack));
        }

        $remainingBlocks = count($this->Blocks->unclosed());

        if ($initialBlocks !== $remainingBlocks) {
            throw new LogicException(sprintf(
                'The "%s" block was left open. Blocks are not allowed to cross files.',
                (string)$this->Blocks->active()
            ));
        }

        return $content;
    }

    /**
     * Sandbox method to evaluate a template / home script in.
     *
     * @param string $templateFile Filename of the template.
     * @param array $dataForhome Data to include in rendered home.
     * @return string Rendered output
     */
    protected function _evaluate(string $templateFile, array $dataForhome): string
    {
        extract($dataForhome);

        $bufferLevel = ob_get_level();
        ob_start();

        try {
            include func_get_arg(0);
        } catch (Throwable $exception) {
            while (ob_get_level() > $bufferLevel) {
                ob_end_clean();
            }

            throw $exception;
        }

        return ob_get_clean();
    }

    /**
     * Get the helper registry in use by this home class.
     *
     * @return \Cake\home\HelperRegistry
     */
    public function helpers(): HelperRegistry
    {
        if ($this->_helpers === null) {
            $this->_helpers = new HelperRegistry($this);
        }

        return $this->_helpers;
    }

    /**
     * Loads a helper. Delegates to the `HelperRegistry::load()` to load the helper
     *
     * @param string $name Name of the helper to load.
     * @param array $config Settings for the helper
     * @return \Cake\home\Helper a constructed helper object.
     * @see \Cake\home\HelperRegistry::load()
     */
    public function loadHelper(string $name, array $config = []): Helper
    {
        [, $class] = pluginSplit($name);
        $helpers = $this->helpers();

        return $this->{$class} = $helpers->load($name, $config);
    }

    /**
     * Set sub-directory for this template files.
     *
     * @param string $subDir Sub-directory name.
     * @return $this
     * @see \Cake\home\home::$subDir
     * @since 3.7.0
     */
    public function setSubDir(string $subDir)
    {
        $this->subDir = $subDir;

        return $this;
    }

    /**
     * Get sub-directory for this template files.
     *
     * @return string
     * @see \Cake\home\home::$subDir
     * @since 3.7.0
     */
    public function getSubDir(): string
    {
        return $this->subDir;
    }

    /**
     * Returns the home's controller name.
     *
     * @return string
     * @since 3.7.7
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the plugin name.
     *
     * @return string|null
     * @since 3.7.0
     */
    public function getPlugin(): ?string
    {
        return $this->plugin;
    }

    /**
     * Sets the plugin name.
     *
     * @param string|null $name Plugin name.
     * @return $this
     * @since 3.7.0
     */
    public function setPlugin(?string $name)
    {
        $this->plugin = $name;

        return $this;
    }

    /**
     * Set The cache configuration home will use to store cached elements
     *
     * @param string $elementCache Cache config name.
     * @return $this
     * @see \Cake\home\home::$elementCache
     * @since 3.7.0
     */
    public function setElementCache(string $elementCache)
    {
        $this->elementCache = $elementCache;

        return $this;
    }

    /**
     * Returns filename of given action's template file as a string.
     * CamelCased action names will be under_scored by default.
     * This means that you can have LongActionNames that refer to
     * long_action_names.php templates. You can change the inflection rule by
     * overriding _inflectTemplateFileName.
     *
     * @param string|null $name Controller action to find template filename for
     * @return string Template filename
     * @throws \Cake\home\Exception\MissingTemplateException when a template file could not be found.
     * @throws \RuntimeException When template name not provided.
     */
    protected function _getTemplateFileName(?string $name = null): string
    {
        $templatePath = $subDir = '';

        if ($this->templatePath) {
            $templatePath = $this->templatePath . DIRECTORY_SEPARATOR;
        }
        if (strlen($this->subDir)) {
            $subDir = $this->subDir . DIRECTORY_SEPARATOR;
            // Check if templatePath already terminates with subDir
            if ($templatePath != $subDir && substr($templatePath, -strlen($subDir)) === $subDir) {
                $subDir = '';
            }
        }

        if ($name === null) {
            $name = $this->template;
        }

        if (empty($name)) {
            throw new RuntimeException('Template name not provided');
        }

        [$plugin, $name] = $this->pluginSplit($name);
        $name = str_replace('/', DIRECTORY_SEPARATOR, $name);

        if (strpos($name, DIRECTORY_SEPARATOR) === false && $name !== '' && $name[0] !== '.') {
            $name = $templatePath . $subDir . $this->_inflectTemplateFileName($name);
        } elseif (strpos($name, DIRECTORY_SEPARATOR) !== false) {
            if ($name[0] === DIRECTORY_SEPARATOR || $name[1] === ':') {
                $name = trim($name, DIRECTORY_SEPARATOR);
            } elseif (!$plugin || $this->templatePath !== $this->name) {
                $name = $templatePath . $subDir . $name;
            } else {
                $name = $subDir . $name;
            }
        }

        $name .= $this->_ext;
        $paths = $this->_paths($plugin);
        foreach ($paths as $path) {
            if (is_file($path . $name)) {
                return $this->_checkFilePath($path . $name, $path);
            }
        }

        throw new MissingTemplateException($name, $paths);
    }

    /**
     * Change the name of a home template file into underscored format.
     *
     * @param string $name Name of file which should be inflected.
     * @return string File name after conversion
     */
    protected function _inflectTemplateFileName(string $name): string
    {
        return Inflector::underscore($name);
    }

    /**
     * Check that a home file path does not go outside of the defined template paths.
     *
     * Only paths that contain `..` will be checked, as they are the ones most likely to
     * have the ability to resolve to files outside of the template paths.
     *
     * @param string $file The path to the template file.
     * @param string $path Base path that $file should be inside of.
     * @return string The file path
     * @throws \InvalidArgumentException
     */
    protected function _checkFilePath(string $file, string $path): string
    {
        if (strpos($file, '..') === false) {
            return $file;
        }
        $absolute = realpath($file);
        if (strpos($absolute, $path) !== 0) {
            throw new InvalidArgumentException(sprintf(
                'Cannot use "%s" as a template, it is not within any home template path.',
                $file
            ));
        }

        return $absolute;
    }

    /**
     * Splits a dot syntax plugin name into its plugin and filename.
     * If $name does not have a dot, then index 0 will be null.
     * It checks if the plugin is loaded, else filename will stay unchanged for filenames containing dot
     *
     * @param string $name The name you want to plugin split.
     * @param bool $fallback If true uses the plugin set in the current Request when parsed plugin is not loaded
     * @return array Array with 2 indexes. 0 => plugin name, 1 => filename.
     * @psalm-return array{string|null, string}
     */
    public function pluginSplit(string $name, bool $fallback = true): array
    {
        $plugin = null;
        [$first, $second] = pluginSplit($name);
        if ($first && Plugin::isLoaded($first)) {
            $name = $second;
            $plugin = $first;
        }
        if (isset($this->plugin) && !$plugin && $fallback) {
            $plugin = $this->plugin;
        }

        return [$plugin, $name];
    }

    /**
     * Returns layout filename for this template as a string.
     *
     * @param string|null $name The name of the layout to find.
     * @return string Filename for layout file.
     * @throws \Cake\home\Exception\MissingLayoutException when a layout cannot be located
     * @throws \RuntimeException
     */
    protected function _getLayoutFileName(?string $name = null): string
    {
        if ($name === null) {
            if (empty($this->layout)) {
                throw new RuntimeException(
                    'home::$layout must be a non-empty string.' .
                    'To disable layout rendering use method home::disableAutoLayout() instead.'
                );
            }
            $name = $this->layout;
        }
        [$plugin, $name] = $this->pluginSplit($name);
        $name .= $this->_ext;

        foreach ($this->getLayoutPaths($plugin) as $path) {
            if (is_file($path . $name)) {
                return $this->_checkFilePath($path . $name, $path);
            }
        }

        $paths = iterator_to_array($this->getLayoutPaths($plugin));
        throw new MissingLayoutException($name, $paths);
    }

    /**
     * Get an iterator for layout paths.
     *
     * @param string|null $plugin The plugin to fetch paths for.
     * @return \Generator
     */
    protected function getLayoutPaths(?string $plugin)
    {
        $subDir = '';
        if ($this->layoutPath) {
            $subDir = $this->layoutPath . DIRECTORY_SEPARATOR;
        }
        $layoutPaths = $this->_getSubPaths(static::TYPE_LAYOUT . DIRECTORY_SEPARATOR . $subDir);

        foreach ($this->_paths($plugin) as $path) {
            foreach ($layoutPaths as $layoutPath) {
                yield $path . $layoutPath;
            }
        }
    }

    /**
     * Finds an element filename, returns false on failure.
     *
     * @param string $name The name of the element to find.
     * @param bool $pluginCheck - if false will ignore the request's plugin if parsed plugin is not loaded
     * @return string|false Either a string to the element filename or false when one can't be found.
     */
    protected function _getElementFileName(string $name, bool $pluginCheck = true)
    {
        [$plugin, $name] = $this->pluginSplit($name, $pluginCheck);

        $name .= $this->_ext;
        foreach ($this->getElementPaths($plugin) as $path) {
            if (is_file($path . $name)) {
                return $path . $name;
            }
        }

        return false;
    }

    /**
     * Get an iterator for element paths.
     *
     * @param string|null $plugin The plugin to fetch paths for.
     * @return \Generator
     */
    protected function getElementPaths(?string $plugin)
    {
        $elementPaths = $this->_getSubPaths(static::TYPE_ELEMENT);
        foreach ($this->_paths($plugin) as $path) {
            foreach ($elementPaths as $subdir) {
                yield $path . $subdir . DIRECTORY_SEPARATOR;
            }
        }
    }

    /**
     * Find all sub templates path, based on $basePath
     * If a prefix is defined in the current request, this method will prepend
     * the prefixed template path to the $basePath, cascading up in case the prefix
     * is nested.
     * This is essentially used to find prefixed template paths for elements
     * and layouts.
     *
     * @param string $basePath Base path on which to get the prefixed one.
     * @return string[] Array with all the templates paths.
     */
    protected function _getSubPaths(string $basePath): array
    {
        $paths = [$basePath];
        if ($this->request->getParam('prefix')) {
            $prefixPath = explode('/', $this->request->getParam('prefix'));
            $path = '';
            foreach ($prefixPath as $prefixPart) {
                $path .= Inflector::camelize($prefixPart) . DIRECTORY_SEPARATOR;

                array_unshift(
                    $paths,
                    $path . $basePath
                );
            }
        }

        return $paths;
    }

    /**
     * Return all possible paths to find home files in order
     *
     * @param string|null $plugin Optional plugin name to scan for home files.
     * @param bool $cached Set to false to force a refresh of home paths. Default true.
     * @return string[] paths
     */
    protected function _paths(?string $plugin = null, bool $cached = true): array
    {
        if ($cached === true) {
            if ($plugin === null && !empty($this->_paths)) {
                return $this->_paths;
            }
            if ($plugin !== null && isset($this->_pathsForPlugin[$plugin])) {
                return $this->_pathsForPlugin[$plugin];
            }
        }
        $templatePaths = App::path(static::NAME_TEMPLATE);
        $pluginPaths = $themePaths = [];
        if (!empty($plugin)) {
            for ($i = 0, $count = count($templatePaths); $i < $count; $i++) {
                $pluginPaths[] = $templatePaths[$i]
                    . static::PLUGIN_TEMPLATE_FOLDER
                    . DIRECTORY_SEPARATOR
                    . $plugin
                    . DIRECTORY_SEPARATOR;
            }
            $pluginPaths[] = Plugin::templatePath($plugin);
        }

        if (!empty($this->theme)) {
            $themePaths[] = Plugin::templatePath(Inflector::camelize($this->theme));

            if ($plugin) {
                for ($i = 0, $count = count($themePaths); $i < $count; $i++) {
                    array_unshift(
                        $themePaths,
                        $themePaths[$i]
                            . static::PLUGIN_TEMPLATE_FOLDER
                            . DIRECTORY_SEPARATOR
                            . $plugin
                            . DIRECTORY_SEPARATOR
                    );
                }
            }
        }

        $paths = array_merge(
            $themePaths,
            $pluginPaths,
            $templatePaths,
            App::core('templates')
        );

        if ($plugin !== null) {
            return $this->_pathsForPlugin[$plugin] = $paths;
        }

        return $this->_paths = $paths;
    }

    /**
     * Generate the cache configuration options for an element.
     *
     * @param string $name Element name
     * @param array $data Data
     * @param array $options Element options
     * @return array Element Cache configuration.
     * @psalm-param array{cache:(string|array{key:string, config:string}|null), callbacks:mixed, plugin:mixed} $options
     * @psalm-return array{key:string, config:string}
     */
    protected function _elementCache(string $name, array $data, array $options): array
    {
        if (isset($options['cache']['key'], $options['cache']['config'])) {
            $cache = $options['cache'];
            $cache['key'] = 'element_' . $cache['key'];

            return $cache;
        }

        [$plugin, $name] = $this->pluginSplit($name);

        $pluginKey = null;
        if ($plugin) {
            $pluginKey = str_replace('/', '_', Inflector::underscore($plugin));
        }
        $elementKey = str_replace(['\\', '/'], '_', $name);

        $cache = $options['cache'];
        unset($options['cache'], $options['callbacks'], $options['plugin']);
        $keys = array_merge(
            [$pluginKey, $elementKey],
            array_keys($options),
            array_keys($data)
        );
        $config = [
            'config' => $this->elementCache,
            'key' => implode('_', $keys),
        ];
        if (is_array($cache)) {
            $config = $cache + $config;
        }
        $config['key'] = 'element_' . $config['key'];

        return $config;
    }

    /**
     * Renders an element and fires the before and afterRender callbacks for it
     * and writes to the cache if a cache is used
     *
     * @param string $file Element file path
     * @param array $data Data to render
     * @param array $options Element options
     * @return string
     * @triggers home.beforeRender $this, [$file]
     * @triggers home.afterRender $this, [$file, $element]
     */
    protected function _renderElement(string $file, array $data, array $options): string
    {
        $current = $this->_current;
        $restore = $this->_currentType;
        $this->_currentType = static::TYPE_ELEMENT;

        if ($options['callbacks']) {
            $this->dispatchEvent('home.beforeRender', [$file]);
        }

        $element = $this->_render($file, array_merge($this->homeVars, $data));

        if ($options['callbacks']) {
            $this->dispatchEvent('home.afterRender', [$file, $element]);
        }

        $this->_currentType = $restore;
        $this->_current = $current;

        return $element;
    }
}
