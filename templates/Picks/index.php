<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Picks

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
        <?= $this->Form->create(null, ['url' => ['action' => 'bulkDelete'], 'id' => 'bulk-delete-form']) ?>
        <div class="box-body table-responsive no-padding">
          <div class="box-footer">
            <?= $this->Form->button(__('Delete Selected'), [
                'type' => 'submit',
                'class' => 'btn btn-danger',
                'onclick' => 'return validateDelete()'
            ]) ?>
          </div>
          <table class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><input type="checkbox" id="select-all"></th>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('denier_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($picks as $pick): ?>
                <tr>
                  <td><?= $this->Form->checkbox('selected_ids[]', ['value' => $pick->id]) ?></td>
                  <td><?= $this->Number->format($pick->id) ?></td>
                  <td><?= h($pick->name) ?></td>
                  <td><?= h($pick->denier->den) ?></td>
                  <td><?= h(Time::parse($pick->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td><?= h(Time::parse($pick->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $pick->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pick->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pick->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pick->id), 'class'=>'btn btn-danger btn-xs']) ?>
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

        <?= $this->Form->end() ?>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>

<script>
  // "Select All" checkbox functionality
  document.getElementById('select-all').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });

  // Function to validate delete action
  function validateDelete() {
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]:checked');
    if (checkboxes.length === 0) {
      alert("Please select at least one pick to delete.");
      return false; // Prevent form submission
    }
    return confirm("Are you sure you want to delete the selected picks?");
  }
</script>
