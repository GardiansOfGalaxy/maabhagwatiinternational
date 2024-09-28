<?php
use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Waterjet
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
                        <dd><?= h($waterjet->date->format('d-m-Y')) ?></dd>
                        <dt scope="row"><?= __('Pick') ?></dt>
                        <dd><?= $waterjet->has('pick') ? $this->Html->link($waterjet->pick->name, ['controller' => 'Picks', 'action' => 'view', $waterjet->pick->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Denier') ?></dt>
                        <dd><?= $waterjet->has('pick') && $waterjet->pick->has('denier') ? h($waterjet->pick->denier->den) : '' ?></dd> <!-- Display denier -->
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($waterjet->id) ?></dd>
                        <dt scope="row"><?= __('Quantity (Meter)') ?></dt>
                        <dd><?= $this->Number->format($waterjet->quantity) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($waterjet->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($waterjet->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>
