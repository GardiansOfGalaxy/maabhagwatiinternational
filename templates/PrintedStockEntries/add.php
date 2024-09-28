<?php
// Use the lastSubmittedDate to set the default value for the date input
$defaultDate = !empty($lastSubmittedDate) ? $lastSubmittedDate : date('Y-m-d', strtotime('-1 day'));
?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PrintedStockEntry $printedStockEntry
 */
?>
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Printed Stock Entry
      <small><?php echo __('Add'); ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo $this->Url->build(['action' => 'index']); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo __('Form'); ?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Form->create($printedStockEntry, ['role' => 'form']); ?>
            <div class="box-body">
              <?php
                    echo $this->Form->control('date', [
                        'default' => $defaultDate, // Set default value to the last submitted date or previous day
                        'type' => 'date'
                    ]);
                    echo $this->Form->control('pick_id', [
                    'options' => $picks,
                    'empty' => 'Select a pick',
                    'id' => 'pick-id'
                ]);
                ?>
                <div id="denier-id" style="font-size: 24px; margin-bottom: 20px;">Select a pick to see the denier</div>
                <div id="quantity-id" style="font-size: 24px; margin-bottom: 20px;">Select a pick to see the quantity</div>
                <?php
                echo $this->Form->control('design_id', ['options' => $designs, 'label'=>'Design Number']);
                echo $this->Form->control('quantity',['label'=>'Quantity (Meter)']);
              ?>
            </div>
            <!-- /.box-body -->

          <?php echo $this->Form->submit(__('Submit')); ?>

          <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.box -->
      </div>
  </div>
  <!-- /.row -->
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pickSelect = document.querySelector('#pick-id'); // Adjust selector as needed
    const denierField = document.querySelector('#denier-id'); // Adjust selector as needed
    const quantityField = document.querySelector('#quantity-id'); // Adjust selector as needed

    pickSelect.addEventListener('change', function () {
        const pickId = this.value;

        if (pickId) {
            // Fetch Denier
            fetch(`/printed-stock-entries/get-denier/${pickId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.denier) {
                        denierField.textContent = `Denier: ${data.denier}`;
                    } else {
                        denierField.textContent = 'Denier information not available';
                    }
                })
                .catch(error => console.error('Error fetching denier:', error));

            // Fetch Total Quantity
            fetch(`/printed-stock-entries/get-total-quantity/${pickId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.totalQuantity) {
                        quantityField.textContent = `Total Quantity: ${data.totalQuantity} meters`;
                    } else {
                        quantityField.textContent = 'Total quantity information not available';
                    }
                })
                .catch(error => console.error('Error fetching total quantity:', error));
        } else {
            denierField.textContent = 'Select a pick to see the denier';
            quantityField.textContent = 'Select a pick to see the quantity'; // Reset message
        }
    });
});

</script>
