<?php

use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Pick
        <small><?php echo __('View'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Url->build(['action' => 'index']); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-info"></i>
                    <h3 class="box-title"><?php echo __('Information'); ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt scope="row"><?= __('Name') ?></dt>
                        <dd><?= h($pick->name) ?></dd>
                        <dt scope="row"><?= __('Denier') ?></dt>
                        <dd><?= $pick->has('denier') ? $this->Html->link($pick->denier->den, ['controller' => 'Deniers', 'action' => 'view', $pick->denier->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($pick->id) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($pick->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($pick->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-share-alt"></i>
                    <h3 class="box-title"><?= __('Dispatch To Own Factories') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($pick->dispatch_to_own_factories)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('Pick Id') ?></th>
                                <th scope="col"><?= __('Factory Name') ?></th>
                                <th scope="col"><?= __('Quantity') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($pick->dispatch_to_own_factories as $dispatchToOwnFactories) : ?>
                                <tr>
                                    <td><?= h($dispatchToOwnFactories->id) ?></td>
                                    <td><?= h($dispatchToOwnFactories->date) ?></td>
                                    <td><?= h($dispatchToOwnFactories->pick_id) ?></td>
                                    <td><?= h($dispatchToOwnFactories->factory_name) ?></td>
                                    <td><?= h($dispatchToOwnFactories->quantity) ?></td>
                                    <td><?= h($dispatchToOwnFactories->created) ?></td>
                                    <td><?= h($dispatchToOwnFactories->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'DispatchToOwnFactories', 'action' => 'view', $dispatchToOwnFactories->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'DispatchToOwnFactories', 'action' => 'edit', $dispatchToOwnFactories->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'DispatchToOwnFactories', 'action' => 'delete', $dispatchToOwnFactories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dispatchToOwnFactories->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-share-alt"></i>
                    <h3 class="box-title"><?= __('Printed Stock Entries') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($pick->printed_stock_entries)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('Pick Id') ?></th>
                                <th scope="col"><?= __('Quantity') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($pick->printed_stock_entries as $printedStockEntries) : ?>
                                <tr>
                                    <td><?= h($printedStockEntries->id) ?></td>
                                    <td><?= h($printedStockEntries->date) ?></td>
                                    <td><?= h($printedStockEntries->pick_id) ?></td>
                                    <td><?= h($printedStockEntries->quantity) ?></td>
                                    <td><?= h($printedStockEntries->created) ?></td>
                                    <td><?= h($printedStockEntries->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'PrintedStockEntries', 'action' => 'view', $printedStockEntries->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'PrintedStockEntries', 'action' => 'edit', $printedStockEntries->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'PrintedStockEntries', 'action' => 'delete', $printedStockEntries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $printedStockEntries->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-share-alt"></i>
                    <h3 class="box-title"><?= __('Waterjets') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($pick->waterjets)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('Pick Id') ?></th>
                                <th scope="col"><?= __('Quantity') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($pick->waterjets as $waterjets) : ?>
                                <tr>
                                    <td><?= h($waterjets->id) ?></td>
                                    <td><?= h($waterjets->date) ?></td>
                                    <td><?= h($waterjets->pick_id) ?></td>
                                    <td><?= h($waterjets->quantity) ?></td>
                                    <td><?= h($waterjets->created) ?></td>
                                    <td><?= h($waterjets->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Waterjets', 'action' => 'view', $waterjets->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Waterjets', 'action' => 'edit', $waterjets->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Waterjets', 'action' => 'delete', $waterjets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waterjets->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
