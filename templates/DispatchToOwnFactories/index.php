<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dispatch To Own Factories

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
                <?= $this->Form->create(null, ['url' => ['action' => 'deleteMultiple'], 'id' => 'delete-multiple-form']) ?>
                <div class="box-body table-responsive no-padding">
                <div class="box-footer">
                    <button type="submit" class="btn btn-danger btn-xs" id="delete-multiple-btn"><?= __('Delete Selected') ?></button>
                </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('pick_id') ?></th>
                                <th scope="col"><?= __('Denier') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('factory_name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Quantity (Meter)') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dispatchToOwnFactories as $dispatchToOwnFactory) : ?>
                                <tr>
                                    <td><input type="checkbox" name="selected_ids[]" value="<?= $dispatchToOwnFactory->id ?>"></td>
                                    <td><?= $this->Number->format($dispatchToOwnFactory->id) ?></td>
                                    <td><?= h($dispatchToOwnFactory->date->format('d-m-Y')) ?></td>
                                    <td><?= h($dispatchToOwnFactory->pick->name) ?></td>
                                    <td><?= h($dispatchToOwnFactory->pick->denier->den) ?></td>
                                    <td><?= h($dispatchToOwnFactory->factory_name) ?></td>
                                    <td><?= $this->Number->format($dispatchToOwnFactory->quantity) ?></td>
                                    <td><?= h(Time::parse($dispatchToOwnFactory->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($dispatchToOwnFactory->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $dispatchToOwnFactory->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dispatchToOwnFactory->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dispatchToOwnFactory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dispatchToOwnFactory->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
        </div>
    </div>
</section>

<script>
    // Select/Deselect All
    document.getElementById('select-all').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }, this);
    });

    // Confirm before deleting
    document.getElementById('delete-multiple-form').addEventListener('submit', function(e) {
        var selected = document.querySelectorAll('input[name="selected_ids[]"]:checked');
        if (selected.length === 0) {
            alert('Please select at least one record to delete.');
            e.preventDefault();
        } else {
            var confirmDelete = confirm('Are you sure you want to delete the selected records?');
            if (!confirmDelete) {
                e.preventDefault();
            }
        }
    });
</script>
