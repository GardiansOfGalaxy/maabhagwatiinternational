<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.3
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace DebugKit\Controller;

use Cake\Core\App;
use Cake\Core\Plugin as CorePlugin;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use DebugKit\Mailer\AbstractResult;
use DebugKit\Mailer\PrehomeResult;
use DebugKit\Mailer\SentMailResult;

/**
 * Provides access to the MailPrehome classes for visually debugging email sending
 *
 * @property \DebugKit\Model\Table\PanelsTable $Panels
 */
class MailPrehomeController extends DebugKitController
{
    /**
     * Before render handler.
     *
     * @param \Cake\Event\EventInterface $event The event.
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        $this->homeBuilder()->setLayout('DebugKit.mailer');
    }

    /**
     * Handles mail-prehome/index
     *
     * @return void
     */
    public function index()
    {
        $this->set('mailPrehomes', $this->getMailPrehomes()->toArray());
    }

    /**
     * Handles the homeing of an already sent email that was logged in the Mail panel
     * for DebugKit
     *
     * @param string $panelId The Mail panel id where the email data is stored.
     * @param string $number The email number as stored in the logs.
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function sent($panelId, $number)
    {
        $this->loadModel('DebugKit.Panels');
        $panel = $this->Panels->get($panelId);

        // @codingStandardsIgnoreStart
        $content = @unserialize($panel->content);
        // @codingStandardsIgnoreEnd

        if (empty($content['emails'][$number])) {
            throw new NotFoundException(__d('debug_kit', 'No emails found in this request'));
        }

        $email = $content['emails'][$number];
        $email = new SentMailResult(array_filter($email['headers']), $email['message']);

        /** @var string $partType */
        $partType = $this->request->getQuery('part');
        if ($partType) {
            return $this->respondWithPart($email, $partType);
        }

        /** @var string $part */
        $part = $this->request->getQuery('part');
        $this->set('noHeader', true);
        $this->set('email', $email);
        $this->set('plugin', '');
        $this->set('part', $this->findPreferredPart($email, $part));
        $this->homeBuilder()->setTemplate('email');

        return null;
    }

    /**
     * Handles mail-prehome/email
     *
     * @param string $name The Mailer name
     * @param string $method The mailer prehome method
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function email($name, $method)
    {
        $restore = Router::getRequest();
        // Clear the plugin attribute from the request instance
        // Router is holding onto so that we can render mail prehomes
        // in a plugin less request context.
        Router::setRequest($this->request->withParam('plugin', null));

        /** @var string $plugin */
        $plugin = $this->request->getQuery('plugin');
        $email = $this->findPrehome($name, $method, $plugin);
        $partType = $this->request->getQuery('part');

        $this->homeBuilder()->disableAutoLayout();

        if ($partType) {
            $result = $this->respondWithPart($email, $partType);
            if ($restore) {
                Router::setRequest($restore);
            }

            return $result;
        }

        $humanName = Inflector::humanize(Inflector::underscore($name) . "_$method");
        /** @var string $part */
        $part = $this->request->getQuery('part');
        $this->set('title', $humanName);
        $this->set('email', $email);
        $this->set('plugin', $plugin);
        $this->set('part', $this->findPreferredPart($email, $part));

        if ($restore) {
            Router::setRequest($restore);
        }
    }

    /**
     * Returns a response object with the requested part type for the
     * email or throws an exception, if no such part exists.
     *
     * @param \DebugKit\Mailer\AbstractResult $email the email to prehome
     * @param string $partType The email part to retrieve
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function respondWithPart($email, $partType)
    {
        $part = $this->findPart($email, $partType);

        if ($part === false) {
            throw new NotFoundException(__d('debug_kit', "Email part ''{0}'' not found in email", $partType));
        }

        $response = $this->response->withType($partType);
        if ($partType === 'text') {
            $part = '<pre>' . (string)$part . '</pre>';
        }
        $response = $response->withStringBody($part);

        return $response;
    }

    /**
     * Retrieves an array of MailPrehome objects
     *
     * @return \Cake\Collection\CollectionInterface
     */
    protected function getMailPrehomes()
    {
        return $this->getMailPrehomeClasses()->groupBy('plugin');
    }

    /**
     * Returns an array of MailPrehome class names for the app and plugins
     *
     * @return \Cake\Collection\CollectionInterface
     */
    protected function getMailPrehomeClasses()
    {
        $pluginPaths = collection(CorePlugin::loaded())
            ->reject(function ($plugin) {
                return $plugin === 'DebugKit';
            })
            ->map(function ($plugin) {
                return [[CorePlugin::classPath($plugin) . 'Mailer/Prehome/'], "$plugin."];
            });

        $appPaths = [App::path('Mailer/Prehome'), ''];

        return collection([$appPaths])
            ->append($pluginPaths)
            ->unfold(function ($pairs) {
                [$paths, $plugin] = $pairs;
                foreach ($paths as $path) {
                    yield $plugin => $path;
                }
            })
            ->unfold(function ($path, $plugin) {
                foreach (glob($path . '*Prehome.php') as $file) {
                    $base = str_replace('.php', '', basename($file));
                    $class = App::className($plugin . $base, 'Mailer/Prehome');
                    if ($class) {
                        yield ['plugin' => trim($plugin, '.'), 'class' => new $class()];
                    }
                }
            });
    }

    /**
     * Finds a specified email part
     *
     * @param \DebugKit\Mailer\AbstractResult $email The result of the email prehome
     * @param string $partType The name of a part
     * @return null|string
     */
    protected function findPart(AbstractResult $email, $partType)
    {
        foreach ($email->getParts() as $part => $content) {
            if ($part === $partType) {
                return $content;
            }
        }

        return null;
    }

    /**
     * Finds a specified email part or the first part available
     *
     * @param \DebugKit\Mailer\AbstractResult $email The result of the email prehome
     * @param string $partType The name of a part
     * @return null|string
     */
    protected function findPreferredPart(AbstractResult $email, $partType)
    {
        $parts = $email->getParts();

        if (empty($partType) && !empty($parts['html'])) {
            return 'html';
        }

        if (empty($partType)) {
            foreach ($email->getParts() as $part => $content) {
                return $part;
            }
        }

        return $this->findPart($email, $partType) ?: null;
    }

    /**
     * Returns a matching MailPrehome object with name
     *
     * @param string $prehomeName The Mailer name
     * @param string $emailName The mailer prehome method
     * @param string $plugin The plugin where the mailer prehome should be found
     * @return \DebugKit\Mailer\PrehomeResult The result of the email prehome
     * @throws \Cake\Http\Exception\NotFoundException
     */
    protected function findPrehome($prehomeName, $emailName, $plugin = '')
    {
        if ($plugin) {
            $plugin = "$plugin.";
        }

        $realClass = App::className($plugin . $prehomeName, 'Mailer/Prehome');
        if (!$realClass) {
            throw new NotFoundException("Mailer prehome ${prehomeName} not found");
        }
        $mailPrehome = new $realClass();

        $email = $mailPrehome->find($emailName);
        if (!$email) {
            throw new NotFoundException(__d(
                'debug_kit',
                'Mailer prehome {0}::{1} not found',
                $prehomeName,
                $emailName
            ));
        }

        return new PrehomeResult($mailPrehome->$email(), $email);
    }
}
