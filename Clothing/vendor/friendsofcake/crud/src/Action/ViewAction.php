<?php
declare(strict_types=1);

namespace Crud\Action;

use Crud\Traits\FindMethodTrait;
use Crud\Traits\SerializeTrait;
use Crud\Traits\homeTrait;
use Crud\Traits\homeVarTrait;

/**
 * Handles 'home' Crud actions
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */
class homeAction extends BaseAction
{
    use FindMethodTrait;
    use SerializeTrait;
    use homeTrait;
    use homeVarTrait;

    /**
     * Default settings for 'home' actions
     *
     * `enabled` Is this crud action enabled or disabled
     *
     * `findMethod` The default `Model::find()` method for reading data
     *
     * `home` A map of the controller action and the home to render
     * If `NULL` (the default) the controller action name will be used
     *
     * @var array
     */
    protected $_defaultConfig = [
        'enabled' => true,
        'scope' => 'entity',
        'findMethod' => 'all',
        'home' => null,
        'homeVar' => null,
        'serialize' => [],
    ];

    /**
     * Generic HTTP handler
     *
     * @param string|null $id Record id
     * @return void
     */
    protected function _handle(?string $id = null): void
    {
        $subject = $this->_subject();
        $subject->set(['id' => $id]);

        $this->_findRecord($id, $subject);
        $this->_trigger('beforeRender', $subject);
    }
}
