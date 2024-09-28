<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Foldings

        <div class="pull-right"><?php echo $this->Html->link(__('New'), ['action' => 'add'], ['class' => 'btn btn-success btn-xs']) ?></div>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('List'); ?></h3>

                    <div class="box-tools">
                        <form action="<?php echo $this->Url->build(); ?>" method="POST">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="<?php echo __('Search'); ?>">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('L') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Design Number') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Meter Per Roll') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('total_rolls') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($foldings as $folding) : ?>
                                <tr>
                                    <td><?= $this->Number->format($folding->id) ?></td>
                                    <td><?= h($folding->date->format('d-m-Y')) ?></td>
                                    <td><?= h($folding->length->L) ?></td>
                                    <td><?= h($folding->design->name) ?></td>
                                    <td><?= h($folding->mtrperroll->number) ?></td>
                                    <td><?= $this->Number->format($folding->total_rolls) ?></td>
                                    <td><?= h(Time::parse($folding->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($folding->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $folding->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $folding->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folding->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                </div>
      </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
