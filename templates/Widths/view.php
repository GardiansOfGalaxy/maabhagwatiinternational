<section class="content-header">
  <h1>
    Width
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
            <dd><?= h($width->name) ?></dd>
            <dt scope="row"><?= __('Pick') ?></dt>
            <dd><?= $width->has('pick') ? $this->Html->link($width->pick->name, ['controller' => 'Picks', 'action' => 'view', $width->pick->id]) : '' ?></dd>
            <dt scope="row"><?= __('Denier') ?></dt>
            <dd><?= $width->has('denier') ? $this->Html->link($width->denier->den, ['controller' => 'Deniers', 'action' => 'view', $width->denier->id]) : '' ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($width->id) ?></dd>
            <dt scope="row"><?= __('Created') ?></dt>
            <dd><?= h($width->created) ?></dd>
            <dt scope="row"><?= __('Modified') ?></dt>
            <dd><?= h($width->modified) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

</section>
