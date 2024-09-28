<?php

use Cake\I18n\Time;
?>
<section class="content-header">
  <h1>
    Printed Stock Entry
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
            <dd><?= h($printedStockEntry->date->format('d-m-Y')) ?></dd>
            <dt scope="row"><?= __('Pick') ?></dt>
            <dd><?= $printedStockEntry->has('pick') ? $this->Html->link($printedStockEntry->pick->name, ['controller' => 'Picks', 'action' => 'view', $printedStockEntry->pick->id]) : '' ?></dd>
            <dt scope="row"><?= __('Denier') ?></dt>
            <dd><?= $printedStockEntry->has('pick') && $printedStockEntry->pick->has('denier') ? h($printedStockEntry->pick->denier->den) : '' ?></dd> <!-- Display denier -->
            <dt scope="row"><?= __('Design') ?></dt>
            <dd><?= $printedStockEntry->has('design') ? $this->Html->link($printedStockEntry->design->name, ['controller' => 'Designs', 'action' => 'view', $printedStockEntry->design->id]) : '' ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($printedStockEntry->id) ?></dd>
                        <dt scope="row"><?= __('Quantity (Meter)') ?></dt>
            <dd><?= $this->Number->format($printedStockEntry->quantity) ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($printedStockEntry->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($printedStockEntry->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

</section>
