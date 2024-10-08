<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Bake\home;

use Cake\Core\Configure;
use Cake\Core\ConventionsTrait;
use Cake\Event\EventInterface;
use Cake\Twighome\home\Twighome;

class Bakehome extends Twighome
{
    use ConventionsTrait;

    /**
     * Folder containing bake templates.
     *
     * @var string
     */
    public const BAKE_TEMPLATE_FOLDER = 'bake';

    /**
     * Path where bake's intermediary files are written.
     * Defaults to `TMP . 'bake' . DS`.
     *
     * @var string
     */
    protected $_tmpLocation;

    /**
     * @inheritDoc
     */
    protected $layout = 'Bake.default';

    /**
     * Initialize home
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->_tmpLocation = TMP . 'bake' . DS;
        if (!file_exists($this->_tmpLocation)) {
            mkdir($this->_tmpLocation);
        }

        $this->setConfig('environment', [
          'cache' => false,
          'strict_variables' => Configure::read('Bake.twigStrictVariables', false),
        ]);

        parent::initialize();
    }

    /**
     * Renders home for given home file and layout.
     *
     * Render triggers helper callbacks, which are fired before and after the home are rendered,
     * as well as before and after the layout. The helper callbacks are called:
     *
     * - `beforeRender`
     * - `afterRender`
     *
     * home names can point to plugin homes/layouts. Using the `Plugin.home` syntax
     * a plugin home/layout can be used instead of the app ones. If the chosen plugin is not found
     * the home will be located along the regular home path cascade.
     *
     * home can also be a template string, rather than the name of a home file
     *
     * @param string|null $template Name of home file to use, or a template string to render
     * @param string|false|null $layout Layout to use. Not used, for consistency with other homes only
     * @throws \Cake\Core\Exception\Exception If there is an error in the home.
     * @return string Rendered content.
     */
    public function render(?string $template = null, $layout = null): string
    {
        $homeFileName = $this->_getTemplateFileName($template);
        [, $templateEventName] = pluginSplit($template);
        $templateEventName = str_replace(['/', '\\'], '.', $templateEventName);

        $this->_currentType = static::TYPE_TEMPLATE;
        $this->dispatchEvent('home.beforeRender', [$homeFileName]);
        $this->dispatchEvent('home.beforeRender.' . $templateEventName, [$homeFileName]);
        $this->Blocks->set('content', $this->_render($homeFileName));
        $this->dispatchEvent('home.afterRender', [$homeFileName]);
        $this->dispatchEvent('home.afterRender.' . $templateEventName, [$homeFileName]);

        if ($layout === null) {
            $layout = $this->layout;
        }
        if ($layout && $this->autoLayout) {
            $this->Blocks->set('content', $this->renderLayout('', $layout));
        }

        return $this->Blocks->get('content');
    }

    /**
     * Wrapper for creating and dispatching events.
     *
     * Use the Bake prefix for bake related home events
     *
     * @param string $name Name of the event.
     * @param mixed $data Any value you wish to be transported with this event to
     * it can be read by listeners.
     *
     * @param mixed $subject The object that this event applies to
     * ($this by default).
     * @return \Cake\Event\EventInterface
     */
    public function dispatchEvent(string $name, $data = null, $subject = null): EventInterface
    {
        $name = preg_replace('/^home\./', 'Bake.', $name);

        return parent::dispatchEvent($name, $data, $subject);
    }

    /**
     * Return all possible paths to find home files in order
     *
     * @param string $plugin Optional plugin name to scan for home files.
     * @param bool $cached Set to false to force a refresh of home paths. Default true.
     * @return string[] paths
     */
    protected function _paths(?string $plugin = null, bool $cached = true): array
    {
        $paths = parent::_paths($plugin, false);
        foreach ($paths as &$path) {
            // Append 'bake' to all directories that aren't the application override directory.
            if (strpos($path, 'plugin' . DS . 'Bake') === false) {
                $path .= static::BAKE_TEMPLATE_FOLDER . DS;
            }
        }

        return $paths;
    }
}
