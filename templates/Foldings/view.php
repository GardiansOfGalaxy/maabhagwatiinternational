<?php

use Cake\I18n\Time;
?>
<section class="content-header">
    <h1>
        Folding
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
                        <dd><?= h($folding->date->format('d-m-Y')) ?></dd>
                        <dt scope="row"><?= __('L') ?></dt>
                        <dd><?= $folding->has('length') ? $this->Html->link($folding->length->L, ['controller' => 'Lengths', 'action' => 'view', $folding->length->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Design Number') ?></dt>
                        <dd><?= $folding->has('design') ? $this->Html->link($folding->design->name, ['controller' => 'Designs', 'action' => 'view', $folding->design->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Meter Per Roll') ?></dt>
                        <dd><?= $folding->has('mtrperroll') ? $this->Html->link($folding->mtrperroll->number, ['controller' => 'Mtrperrolls', 'action' => 'view', $folding->mtrperroll->id]) : '' ?></dd>
                        <dt scope="row"><?= __('Id') ?></dt>
                        <dd><?= $this->Number->format($folding->id) ?></dd>
                        <dt scope="row"><?= __('Total Rolls') ?></dt>
                        <dd><?= $this->Number->format($folding->total_rolls) ?></dd>
                        <dt scope="row"><?= __('Created') ?></dt>
                        <dd><?= h(Time::parse($folding->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                        <dt scope="row"><?= __('Modified') ?></dt>
                        <dd><?= h(Time::parse($folding->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</section>
