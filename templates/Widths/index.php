<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Widths
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
        <?= $this->Form->create(null, ['url' => ['action' => 'deleteMultiple'], 'id' => 'multiple-delete-form']) ?>
        <div class="box-body table-responsive no-padding">
        <div class="box-footer">
          <button type="button" class="btn btn-danger" id="delete-selected"><?= __('Delete Selected') ?></button>
        </div>
          <table class="table table-hover">
            <thead>
              <tr>
                  <th><input type="checkbox" id="select-all"></th> <!-- Checkbox to select all -->
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('pick_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('denier_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($widths as $width): ?>
                <tr>
                  <td><input type="checkbox" name="ids[]" value="<?= $width->id ?>"></td> <!-- Row checkbox -->
                  <td><?= $this->Number->format($width->id) ?></td>
                  <td><?= h($width->name) ?></td>
                  <td><?= $this->Number->format($width->pick->name) ?></td>
                  <td><?= $this->Number->format($width->denier->den) ?></td>
                  <td><?= h($width->created) ?></td>
                  <td><?= h($width->modified) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $width->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $width->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $width->id], ['confirm' => __('Are you sure you want to delete # {0}?', $width->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?= $this->Form->end() ?>
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

<!-- JavaScript for handling multiple delete -->
<script>
document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[name="ids[]"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}

document.getElementById('delete-selected').onclick = function() {
    var selected = document.querySelectorAll('input[name="ids[]"]:checked');
    if (selected.length === 0) {
        alert('Please select at least one record to delete.');
    } else {
        if (confirm('Are you sure you want to delete the selected records?')) {
            document.getElementById('multiple-delete-form').submit();
        }
    }
}
</script>
