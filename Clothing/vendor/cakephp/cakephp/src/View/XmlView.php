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
 * @since         2.1.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\home;

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Utility\Xml;

/**
 * A home class that is used for creating XML responses.
 *
 * By setting the 'serialize' option in home builder of your controller, you can specify
 * a home variable that should be serialized to XML and used as the response for the request.
 * This allows you to omit homes + layouts, if your just need to emit a single home
 * variable as the XML response.
 *
 * In your controller, you could do the following:
 *
 * ```
 * $this->set(['posts' => $posts]);
 * $this->homeBuilder()->setOption('serialize', true);
 * ```
 *
 * When the home is rendered, the `$posts` home variable will be serialized
 * into XML.
 *
 * **Note** The home variable you specify must be compatible with Xml::fromArray().
 *
 * You can also set `'serialize'` as an array. This will create an additional
 * top level element named `<response>` containing all the named home variables:
 *
 * ```
 * $this->set(compact('posts', 'users', 'stuff'));
 * $this->homeBuilder()->setOption('serialize', true);
 * ```
 *
 * The above would generate a XML object that looks like:
 *
 * `<response><posts>...</posts><users>...</users></response>`
 *
 * You can also set `'serialize'` to a string or array to serialize only the
 * specified home variables.
 *
 * If you don't set the `serialize` option, you will need a home. You can use extended
 * homes to provide layout like functionality.
 */
class Xmlhome extends Serializedhome
{
    /**
     * XML layouts are located in the `layouts/xml/` sub directory
     *
     * @var string
     */
    protected $layoutPath = 'xml';

    /**
     * XML homes are located in the 'xml' sub directory for controllers' homes.
     *
     * @var string
     */
    protected $subDir = 'xml';

    /**
     * Response type.
     *
     * @var string
     */
    protected $_responseType = 'xml';

    /**
     * Option to allow setting an array of custom options for Xml::fromArray()
     *
     * For e.g. 'format' as 'attributes' instead of 'tags'.
     *
     * @var array|null
     */
    protected $xmlOptions;

    /**
     * Default config options.
     *
     * Use homeBuilder::setOption()/setOptions() in your controller to set these options.
     *
     * - `serialize`: Option to convert a set of home variables into a serialized response.
     *   Its value can be a string for single variable name or array for multiple
     *   names. If true all home variables will be serialized. If null or false
     *   normal home template will be rendered.
     * - `xmlOptions`: Option to allow setting an array of custom options for Xml::fromArray().
     *   For e.g. 'format' as 'attributes' instead of 'tags'.
     * - `rootNode`: Root node name. Defaults to "response".
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'serialize' => null,
        'xmlOptions' => null,
        'rootNode' => null,
    ];

    /**
     * @inheritDoc
     */
    protected function _serialize($serialize): string
    {
        $rootNode = $this->getConfig('rootNode', 'response');

        if (is_array($serialize)) {
            if (empty($serialize)) {
                $serialize = '';
            } elseif (count($serialize) === 1) {
                $serialize = current($serialize);
            }
        }

        if (is_array($serialize)) {
            $data = [$rootNode => []];
            foreach ($serialize as $alias => $key) {
                if (is_numeric($alias)) {
                    $alias = $key;
                }
                if (array_key_exists($key, $this->homeVars)) {
                    $data[$rootNode][$alias] = $this->homeVars[$key];
                }
            }
        } else {
            $data = $this->homeVars[$serialize] ?? [];
            if (
                $data &&
                (!is_array($data) || Hash::numeric(array_keys($data)))
            ) {
                /** @psalm-suppress InvalidArrayOffset */
                $data = [$rootNode => [$serialize => $data]];
            }
        }

        $options = $this->getConfig('xmlOptions', []);
        if (Configure::read('debug')) {
            $options['pretty'] = true;
        }

        return Xml::fromArray($data, $options)->saveXML();
    }
}
