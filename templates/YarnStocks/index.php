<?php
use Cake\I18n\Time;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Yarn Stocks
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

        <!-- Form for multiple delete -->
        <?= $this->Form->create(null, ['url' => ['action' => 'multiDelete'], 'id' => 'multiDeleteForm']) ?>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all"></th> <!-- Select All checkbox -->
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('denier_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('agent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Company Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('boxes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('kg') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($yarnStocks as $yarnStock): ?>
                <tr>
                  <td><input type="checkbox" name="ids[]" value="<?= $yarnStock->id ?>"></td> <!-- Checkbox for each row -->
                  <td><?= h($yarnStock->date->format('d-m-Y')) ?></td>
                  <td><?= $this->Number->format($yarnStock->id) ?></td>
                  <td><?= h($yarnStock->denier->den) ?></td>
                  <td><?= h($yarnStock->agent->name) ?></td>
                  <td><?= h($yarnStock->customer_name) ?></td>
                  <td><?= $this->Number->format($yarnStock->boxes) ?></td>
                  <td><?= $this->Number->format($yarnStock->kg) ?></td>
                  <td><?= h(Time::parse($yarnStock->created)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td><?= h(Time::parse($yarnStock->modified)->timezone('Asia/Kolkata')->i18nFormat('dd-MMM-yyyy hh:mm a')) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $yarnStock->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $yarnStock->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $yarnStock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $yarnStock->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->

        <!-- Delete Selected Button -->
        <div class="box-footer">
          <button type="button" class="btn btn-danger btn-xs" id="delete-selected"><?= __('Delete Selected') ?></button>
        </div>

        <?= $this->Form->end() ?> <!-- End of Form -->

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

<!-- JavaScript for handling delete confirmation and select all functionality -->
<script>
  // Select all checkboxes
  document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
  });

  // Delete selected records with confirmation
  document.getElementById('delete-selected').addEventListener('click', function() {
    const selected = document.querySelectorAll('input[name="ids[]"]:checked');

    if (selected.length === 0) {
      alert('Please select at least one record to delete.');
    } else if (confirm('Are you sure you want to delete the selected records?')) {
      document.getElementById('multiDeleteForm').submit();
    }
  });
</script>
