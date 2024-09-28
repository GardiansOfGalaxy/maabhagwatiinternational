<?php

use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Design
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
                        <dt scope="row"><?= __('Design Number') ?></dt>
                        <dd><?= h($design->name) ?></dd>
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($design->id) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($design->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($design->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
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
                    <h3 class="box-title"><?= __('Dispatch Stock Sales') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($design->dispatch_stock_sales)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('L') ?></th>
                                <th scope="col"><?= __('Design Name') ?></th>
                                <th scope="col"><?= __('Total No Rolls') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($design->dispatch_stock_sales as $dispatchStockSales) : ?>
                                <tr>
                                    <td><?= h($dispatchStockSales->id) ?></td>
                                    <td><?= h($dispatchStockSales->date) ?></td>
                                    <td><?= h($dispatchStockSales->length->L) ?></td>
                                    <td><?= h($dispatchStockSales->design->name) ?></td>
                                    <td><?= h($dispatchStockSales->total_no_rolls) ?></td>
                                    <td><?= h($dispatchStockSales->created) ?></td>
                                    <td><?= h($dispatchStockSales->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'DispatchStockSales', 'action' => 'view', $dispatchStockSales->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'DispatchStockSales', 'action' => 'edit', $dispatchStockSales->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'DispatchStockSales', 'action' => 'delete', $dispatchStockSales->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dispatchStockSales->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
                    <h3 class="box-title"><?= __('Foldings') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($design->foldings)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('L') ?></th>
                                <th scope="col"><?= __('Design Name') ?></th>
                                <th scope="col"><?= __('Meter Per Roll') ?></th>
                                <th scope="col"><?= __('Total Rolls') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($design->foldings as $foldings) : ?>
                                <tr>
                                    <td><?= h($foldings->id) ?></td>
                                    <td><?= h($foldings->date) ?></td>
                                    <td><?= h($foldings->length->L) ?></td>
                                    <td><?= h($foldings->design->name) ?></td>
                                    <td><?= h($foldings->mtrperroll->number) ?></td>
                                    <td><?= h($foldings->total_rolls) ?></td>
                                    <td><?= h($foldings->created) ?></td>
                                    <td><?= h($foldings->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Foldings', 'action' => 'view', $foldings->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Foldings', 'action' => 'edit', $foldings->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Foldings', 'action' => 'delete', $foldings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $foldings->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
