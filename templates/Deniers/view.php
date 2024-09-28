<?php

use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Denier
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
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($denier->id) ?></dd>
                        <dt scope="row"><?= __('Denier') ?></dt>
                        <dd><?= $this->Number->format($denier->den) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($denier->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($denier->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
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
                    <h3 class="box-title"><?= __('Picks') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($denier->picks)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('Denier Id') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($denier->picks as $picks) : ?>
                                <tr>
                                    <td><?= h($picks->id) ?></td>
                                    <td><?= h($picks->name) ?></td>
                                    <td><?= h($picks->denier_id) ?></td>
                                    <td><?= h($picks->created) ?></td>
                                    <td><?= h($picks->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Picks', 'action' => 'view', $picks->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Picks', 'action' => 'edit', $picks->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Picks', 'action' => 'delete', $picks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $picks->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
                    <h3 class="box-title"><?= __('Yarn Stocks') ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (!empty($denier->yarn_stocks)) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Denier Id') ?></th>
                                <th scope="col"><?= __('Agent Id') ?></th>
                                <th scope="col"><?= __('Date') ?></th>
                                <th scope="col"><?= __('Boxes') ?></th>
                                <th scope="col"><?= __('Kg') ?></th>
                                <th scope="col"><?= __('Created') ?></th>
                                <th scope="col"><?= __('Modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($denier->yarn_stocks as $yarnStocks) : ?>
                                <tr>
                                    <td><?= h($yarnStocks->id) ?></td>
                                    <td><?= h($yarnStocks->denier_id) ?></td>
                                    <td><?= h($yarnStocks->agent_id) ?></td>
                                    <td><?= h($yarnStocks->date) ?></td>
                                    <td><?= h($yarnStocks->boxes) ?></td>
                                    <td><?= h($yarnStocks->kg) ?></td>
                                    <td><?= h($yarnStocks->created) ?></td>
                                    <td><?= h($yarnStocks->modified) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['controller' => 'YarnStocks', 'action' => 'view', $yarnStocks->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'YarnStocks', 'action' => 'edit', $yarnStocks->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'YarnStocks', 'action' => 'delete', $yarnStocks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $yarnStocks->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
