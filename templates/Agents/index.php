<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Agents
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

                <div class="box-body table-responsive no-padding">
                    <!-- Form to submit selected agents for deletion -->
                    <?= $this->Form->create(null, ['url' => ['action' => 'deleteMultiple'], 'id' => 'deleteMultipleForm', 'onsubmit' => 'return confirmDelete();']) ?>
                    <div class="pull-left">
                        <button type="submit" class="btn btn-danger btn-xs"><?= __('Delete Selected') ?></button> <!-- Delete Selected Button -->
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th> <!-- Check/Uncheck All -->
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agents as $agent) : ?>
                                <tr>
                                    <td><input type="checkbox" name="selected_agents[]" value="<?= $agent->id ?>"></td> <!-- Individual checkboxes -->
                                    <td><?= $this->Number->format($agent->id) ?></td>
                                    <td><?= h($agent->name) ?></td>
                                    <td><?= h(Time::parse($agent->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($agent->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $agent->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $agent->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $agent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agent->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->Form->end() ?>
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
            <!-- /.box -->
        </div>
    </div>
</section>

<!-- JavaScript to handle select all functionality and delete confirmation -->
<script>
    // Select/Unselect all checkboxes
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="selected_agents[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    // Confirmation before deleting selected items
    function confirmDelete() {
        var selected = document.querySelectorAll('input[name="selected_agents[]"]:checked');
        if (selected.length > 0) {
            return confirm('Are you sure you want to delete the selected items?');
        } else {
            alert('Please select at least one item to delete.');
            return false;
        }
    }
</script>
