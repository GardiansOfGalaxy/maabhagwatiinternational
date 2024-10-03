<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Meter Per Roll
        <div class="pull-right">
            <?php echo $this->Html->link(__('New'), ['action' => 'add'], ['class' => 'btn btn-success btn-xs']) ?>
        </div>
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

                <!-- Form for multiple delete -->
                <?= $this->Form->create(null, ['url' => ['action' => 'deleteSelected'], 'id' => 'deleteForm']) ?>
                <div class="box-body table-responsive no-padding">
                     <!-- Delete Selected Button -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-danger" onclick="return confirmDelete()"><?= __('Delete Selected') ?></button>
                </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th> <!-- Select All checkbox -->
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('number') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mtrperrolls as $mtrperroll) : ?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?= $mtrperroll->id ?>"></td> <!-- Checkbox for each row -->
                                    <td><?= $this->Number->format($mtrperroll->id) ?></td>
                                    <td><?= $this->Number->format($mtrperroll->number) ?></td>
                                    <td><?= h(Time::parse($mtrperroll->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td><?= h(Time::parse($mtrperroll->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                                    <td class="actions text-right">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $mtrperroll->id], ['class' => 'btn btn-info btn-xs']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mtrperroll->id], ['class' => 'btn btn-warning btn-xs']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $mtrperroll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mtrperroll->id), 'class' => 'btn btn-danger btn-xs']) ?>
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
            <!-- /.box -->
        </div>
    </div>
</section>

<!-- JavaScript for Select All and Confirm Delete -->
<script type="text/javascript">
    // Select/Deselect all checkboxes
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.getElementsByName('ids[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

    // Confirm before deleting
    function confirmDelete() {
        return confirm("Are you sure you want to delete the selected records?");
    }
</script>
