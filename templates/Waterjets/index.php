<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Waterjets
    <div class="pull-right"><?php echo $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
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
          <button type="button" class="btn btn-danger" id="deleteSelectedBtn"><?= __('Delete Selected') ?></button>

          <?= $this->Form->create(null, ['url' => ['action' => 'bulkDelete'], 'id' => 'bulkDeleteForm']) ?>
          <table class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><input type="checkbox" id="selectAll" /></th> <!-- Select All checkbox -->
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('pick_id') ?></th>
                  <th scope="col"><?= __('Denier') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('Quantity (Meter)') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($waterjets as $waterjet): ?>
                <tr>
                  <td><input type="checkbox" name="selected_ids[]" value="<?= $waterjet->id ?>" class="selectCheckbox"></td> <!-- Checkbox for each row -->
                  <td><?= $this->Number->format($waterjet->id) ?></td>
                  <td><?= h($waterjet->date->format('d-m-Y')) ?></td>
                  <td><?= h($waterjet->pick->name) ?></td>
                  <td><?= h($waterjet->pick->denier->den) ?></td> <!-- Display denier -->
                  <td><?= $this->Number->format($waterjet->quantity) ?></td>
                  <td><?= h(Time::parse($waterjet->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td><?= h(Time::parse($waterjet->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $waterjet->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $waterjet->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $waterjet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $waterjet->id), 'class'=>'btn btn-danger btn-xs']) ?>
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
    </div>
    <!-- /.box -->
  </div>
</div>
</section>

<!-- Add this script block for the confirmation and checkbox selection -->
<script>
document.getElementById('selectAll').addEventListener('click', function(event) {
    let checkboxes = document.querySelectorAll('.selectCheckbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = event.target.checked;
    });
});

document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
    let selected = document.querySelectorAll('.selectCheckbox:checked');
    if (selected.length === 0) {
        alert('Please select at least one item to delete.');
    } else if (confirm('Are you sure you want to delete the selected items?')) {
        document.getElementById('bulkDeleteForm').submit();
    }
});
</script>
