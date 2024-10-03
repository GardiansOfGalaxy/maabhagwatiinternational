<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Designs
        <div class="pull-right">
            <?= $this->Html->link(__('New'), ['action' => 'add'], ['class' => 'btn btn-success btn-xs']) ?>
        </div>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= __('List') ?></h3>

                    <div class="box-tools">
                        <form action="<?= $this->Url->build(); ?>" method="POST">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="<?= __('Search'); ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- Form for multiple delete -->
                <?= $this->Form->create(null, ['url' => ['action' => 'deleteMultiple'], 'id' => 'deleteMultipleForm']) ?>

                <div class="box-body table-responsive no-padding">
                    <div class="pull-left">
                        <button type="submit" class="btn btn-danger btn-xs" id="delete-selected"><?= __('Delete Selected') ?></button> <!-- Delete Selected Button -->
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th> <!-- Check/Uncheck All -->
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Design Number') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($designs as $design) : ?>
                                <tr>
                                    <td><input type="checkbox" name="selected_designs[]" value="<?= $design->id ?>"></td> <!-- Individual checkboxes -->
                                    <td><?= $this->Number->format($design->id) ?></td>
                                    <td><?= h($design->name) ?></td>
                                    <td><?= h(Time::parse($design->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($design->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $design->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $design->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $design->id], ['confirm' => __('Are you sure you want to delete # {0}?', $design->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <!-- /.box-body -->
                <?= $this->Form->end() ?>

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
            <!-- /.box -->
        </div>
    </div>
</section>

<!-- JavaScript for select all and confirmation -->
<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="selected_designs[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    document.getElementById('delete-selected').onclick = function(e) {
        var checkboxes = document.querySelectorAll('input[name="selected_designs[]"]:checked');
        if (checkboxes.length === 0) {
            alert("Please select at least one design to delete.");
            e.preventDefault();
        } else {
            if (!confirm("Are you sure you want to delete the selected items?")) {
                e.preventDefault();
            }
        }
    }
</script>
