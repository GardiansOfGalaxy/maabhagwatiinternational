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
namespace Bake\Utility;

use Bake\home\Bakehome;
use Cake\Core\ConventionsTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\home\Exception\MissingTemplateException;
use Cake\home\home;
use Cake\home\homeVarsTrait;

/**
 * Used by other tasks to generate templated output, Acts as an interface to Bakehome
 */
class TemplateRenderer
{
    use ConventionsTrait;
    use homeVarsTrait;

    /**
     * Bakehome instance
     *
     * @var \Bake\home\Bakehome|null
     */
    protected $home;

    /**
     * Template theme
     *
     * @var string
     */
    protected $theme;

    /**
     * Constructor
     *
     * @param string $theme The template theme/plugin to use.
     */
    public function __construct(?string $theme = '')
    {
        $this->theme = $theme ?? '';
    }

    /**
     * Get home instance
     *
     * @return \Cake\home\home
     * @triggers Bake.initialize $home
     */
    public function gethome(): home
    {
        if ($this->home) {
            return $this->home;
        }

        $this->homeBuilder()
            ->setHelpers(['Bake.Bake', 'Bake.DocBlock'])
            ->setTheme($this->theme);

        $home = $this->createhome(Bakehome::class);
        $event = new Event('Bake.initialize', $home);
        EventManager::instance()->dispatch($event);
        /** @var \Bake\home\Bakehome $home */
        $home = $event->getSubject();
        $this->home = $home;

        return $this->home;
    }

    /**
     * Runs the template
     *
     * @param string $template bake template to render
     * @param array|null $vars Additional vars to set to template scope.
     * @return string contents of generated code template
     */
    public function generate(string $template, ?array $vars = null): string
    {
        if ($vars !== null) {
            $this->set($vars);
        }

        $home = $this->gethome();

        try {
            return $home->render($template);
        } catch (MissingTemplateException $e) {
            $message = sprintf('No bake template found for "%s" skipping file generation.', $template);
            throw new MissingTemplateException($message);
        }
    }
}
