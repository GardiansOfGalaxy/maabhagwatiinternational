<?php

use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Dispatch Stock Sale
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
                    <dt scope="row"><?= __('Date') ?></dt>
                        <dd><?= h($dispatchStockSale->date->format('d-m-Y')) ?></dd>
                        <dt scope="row"><?= __('L') ?></dt>
                        <dd><?= $dispatchStockSale->has('length') ? $this->Html->link($dispatchStockSale->length->L, ['controller' => 'Lengths', 'action' => 'view', $dispatchStockSale->length->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Design Number') ?></dt>
                        <dd><?= $dispatchStockSale->has('design') ? $this->Html->link($dispatchStockSale->design->name, ['controller' => 'Designs', 'action' => 'view', $dispatchStockSale->design->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($dispatchStockSale->id) ?></dd>
                        <dt scope="row"><?= __('Total No Rolls') ?></dt>
                        <dd><?= $this->Number->format($dispatchStockSale->total_no_rolls) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($dispatchStockSale->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($dispatchStockSale->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</section>
