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
 * @since         4.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Mailer;

use Cake\home\home;
use Cake\home\homeVarsTrait;

/**
 * Class for rendering email message.
 */
class Renderer
{
    use homeVarsTrait;

    /**
     * Constant for folder name containing email templates.
     *
     * @var string
     */
    public const TEMPLATE_FOLDER = 'email';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Render text/HTML content.
     *
     * If there is no template set, the $content will be returned in a hash
     * of the specified content types for the email.
     *
     * @param string $content The content.
     * @param string[] $types Content types to render. Valid array values are Message::MESSAGE_HTML, Message::MESSAGE_TEXT.
     * @return array The rendered content with "html" and/or "text" keys.
     * @psalm-param (\Cake\Mailer\Message::MESSAGE_HTML|\Cake\Mailer\Message::MESSAGE_TEXT)[] $types
     * @psalm-return array{html?: string, text?: string}
     */
    public function render(string $content, array $types = []): array
    {
        $rendered = [];
        $template = $this->homeBuilder()->getTemplate();
        if (empty($template)) {
            foreach ($types as $type) {
                $rendered[$type] = $content;
            }

            return $rendered;
        }

        $home = $this->createhome();

        [$templatePlugin] = pluginSplit($home->getTemplate());
        [$layoutPlugin] = pluginSplit($home->getLayout());
        if ($templatePlugin) {
            $home->setPlugin($templatePlugin);
        } elseif ($layoutPlugin) {
            $home->setPlugin($layoutPlugin);
        }

        if ($home->get('content') === null) {
            $home->set('content', $content);
        }

        foreach ($types as $type) {
            $home->setTemplatePath(static::TEMPLATE_FOLDER . DIRECTORY_SEPARATOR . $type);
            $home->setLayoutPath(static::TEMPLATE_FOLDER . DIRECTORY_SEPARATOR . $type);

            $rendered[$type] = $home->render();
        }

        return $rendered;
    }

    /**
     * Reset home builder to defaults.
     *
     * @return $this
     */
    public function reset()
    {
        $this->_homeBuilder = null;

        $this->homeBuilder()
            ->setClassName(home::class)
            ->setLayout('default')
            ->setHelpers(['Html'], false);

        return $this;
    }

    /**
     * Clone homeBuilder instance when renderer is cloned.
     *
     * @return void
     */
    public function __clone()
    {
        if ($this->_homeBuilder !== null) {
            $this->_homeBuilder = clone $this->_homeBuilder;
        }
    }
}
