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

use Cake\Core\Exception\CakeException;

/**
 * homeBlock implements the concept of Blocks or Slots in the home layer.
 * Slots or blocks are combined with extending homes and layouts to afford slots
 * of content that are present in a layout or parent home, but are defined by the child
 * home or elements used in the home.
 */
class homeBlock
{
    /**
     * Override content
     *
     * @var string
     */
    public const OVERRIDE = 'override';

    /**
     * Append content
     *
     * @var string
     */
    public const APPEND = 'append';

    /**
     * Prepend content
     *
     * @var string
     */
    public const PREPEND = 'prepend';

    /**
     * Block content. An array of blocks indexed by name.
     *
     * @var string[]
     */
    protected $_blocks = [];

    /**
     * The active blocks being captured.
     *
     * @var string[]
     */
    protected $_active = [];

    /**
     * Should the currently captured content be discarded on homeBlock::end()
     *
     * @see \Cake\home\homeBlock::end()
     * @var bool
     */
    protected $_discardActiveBufferOnEnd = false;

    /**
     * Start capturing output for a 'block'
     *
     * Blocks allow you to create slots or blocks of dynamic content in the layout.
     * home files can implement some or all of a layout's slots.
     *
     * You can end capturing blocks using home::end(). Blocks can be output
     * using home::get();
     *
     * @param string $name The name of the block to capture for.
     * @param string $mode If homeBlock::OVERRIDE existing content will be overridden by new content.
     *   If homeBlock::APPEND content will be appended to existing content.
     *   If homeBlock::PREPEND it will be prepended.
     * @throws \Cake\Core\Exception\CakeException When starting a block twice
     * @return void
     */
    public function start(string $name, string $mode = homeBlock::OVERRIDE): void
    {
        if (array_key_exists($name, $this->_active)) {
            throw new CakeException(sprintf("A home block with the name '%s' is already/still open.", $name));
        }
        $this->_active[$name] = $mode;
        ob_start();
    }

    /**
     * End a capturing block. The compliment to homeBlock::start()
     *
     * @return void
     * @see \Cake\home\homeBlock::start()
     */
    public function end(): void
    {
        if ($this->_discardActiveBufferOnEnd) {
            $this->_discardActiveBufferOnEnd = false;
            ob_end_clean();

            return;
        }

        if (!$this->_active) {
            return;
        }

        $mode = end($this->_active);
        $active = key($this->_active);
        $content = ob_get_clean();
        if ($mode === homeBlock::OVERRIDE) {
            $this->_blocks[$active] = (string)$content;
        } else {
            $this->concat($active, $content, $mode);
        }
        array_pop($this->_active);
    }

    /**
     * Concat content to an existing or new block.
     * Concating to a new block will create the block.
     *
     * Calling concat() without a value will create a new capturing
     * block that needs to be finished with home::end(). The content
     * of the new capturing context will be added to the existing block context.
     *
     * @param string $name Name of the block
     * @param mixed $value The content for the block. Value will be type cast
     *   to string.
     * @param string $mode If homeBlock::APPEND content will be appended to existing content.
     *   If homeBlock::PREPEND it will be prepended.
     * @return void
     */
    public function concat(string $name, $value = null, $mode = homeBlock::APPEND): void
    {
        if ($value === null) {
            $this->start($name, $mode);

            return;
        }

        if (!isset($this->_blocks[$name])) {
            $this->_blocks[$name] = '';
        }
        if ($mode === homeBlock::PREPEND) {
            $this->_blocks[$name] = $value . $this->_blocks[$name];
        } else {
            $this->_blocks[$name] .= $value;
        }
    }

    /**
     * Set the content for a block. This will overwrite any
     * existing content.
     *
     * @param string $name Name of the block
     * @param mixed $value The content for the block. Value will be type cast
     *   to string.
     * @return void
     */
    public function set(string $name, $value): void
    {
        $this->_blocks[$name] = (string)$value;
    }

    /**
     * Get the content for a block.
     *
     * @param string $name Name of the block
     * @param string $default Default string
     * @return string The block content or $default if the block does not exist.
     */
    public function get(string $name, string $default = ''): string
    {
        if (!isset($this->_blocks[$name])) {
            return $default;
        }

        return $this->_blocks[$name];
    }

    /**
     * Check if a block exists
     *
     * @param string $name Name of the block
     * @return bool
     */
    public function exists(string $name): bool
    {
        return isset($this->_blocks[$name]);
    }

    /**
     * Get the names of all the existing blocks.
     *
     * @return string[] An array containing the blocks.
     */
    public function keys(): array
    {
        return array_keys($this->_blocks);
    }

    /**
     * Get the name of the currently open block.
     *
     * @return string|null Either null or the name of the last open block.
     */
    public function active(): ?string
    {
        end($this->_active);

        return key($this->_active);
    }

    /**
     * Get the unclosed/active blocks. Key is name, value is mode.
     *
     * @return string[] An array of unclosed blocks.
     */
    public function unclosed(): array
    {
        return $this->_active;
    }
}
