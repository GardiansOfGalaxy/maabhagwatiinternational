<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Deniers
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
                    <!-- Form to submit selected items for deletion -->
                    <?= $this->Form->create(null, ['url' => ['action' => 'deleteMultiple'], 'id' => 'deleteMultipleForm']) ?>

                    <!-- Add Delete Selected Button -->
                    <div class="pull-left">
                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete selected items?');"><?= __('Delete Selected') ?></button>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <!-- Checkbox for selecting all -->
                                <th><input type="checkbox" id="select-all"></th>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('den', ['label' => 'Denier']) ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deniers as $denier) : ?>
                                <tr>
                                    <!-- Checkbox for each row -->
                                    <td><?= $this->Form->checkbox('selected_ids[]', ['value' => $denier->id]) ?></td>
                                    <td><?= $this->Number->format($denier->id) ?></td>
                                    <td><?= $this->Number->format($denier->den) ?></td>
                                    <td><?= h(Time::parse($denier->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($denier->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $denier->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $denier->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $denier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $denier->id), 'class' => 'btn btn-danger btn-xs']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- End the form -->
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
        </div>
        <!-- /.box -->
    </div>
</section>

<!-- JavaScript to Select All Checkboxes -->
<script>
    document.getElementById('select-all').addEventListener('click', function(event) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
    });
</script>
