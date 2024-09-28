<?php
use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Yarn Stock
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
                        <dd><?= h($yarnStock->date->format('d-m-Y')) ?></dd>
                        <dt scope="row"><?= __('Denier') ?></dt>
                        <dd><?= $yarnStock->has('denier') ? $this->Html->link($yarnStock->denier->den, ['controller' => 'Deniers', 'action' => 'view', $yarnStock->denier->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Agent') ?></dt>
                        <dd><?= $yarnStock->has('agent') ? $this->Html->link($yarnStock->agent->name, ['controller' => 'Agents', 'action' => 'view', $yarnStock->agent->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Company Name') ?></dt>
                        <dd><?= h($yarnStock->customer_name) ?></dd>
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($yarnStock->id) ?></dd>
                        <dt scope="row"><?= __('Boxes') ?></dt>
                        <dd><?= $this->Number->format($yarnStock->boxes) ?></dd>
                        <dt scope="row"><?= __('Kg') ?></dt>
                        <dd><?= $this->Number->format($yarnStock->kg) ?></dd>
                         <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($yarnStock->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($yarnStock->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</section>
