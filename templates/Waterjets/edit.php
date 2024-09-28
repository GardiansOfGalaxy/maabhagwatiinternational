<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Waterjet $waterjet
 * @var array $picks
 * @var string|null $denier
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Waterjet
        <small><?php echo __('Edit'); ?></small>
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
                <?php echo $this->Form->create($waterjet, ['role' => 'form']); ?>
                <div class="box-body">
                    <?php
                        echo $this->Form->control('date');
                        echo $this->Form->control('pick_id', [
                            'options' => $picks,
                            'empty' => 'Select a pick',
                            'id' => 'pick-id'
                        ]);
                    ?>
                    <div id="denier-display" style="font-size: 24px; margin-bottom: 20px;">
                        <?php echo $denier ? 'Denier: ' . h($denier) : 'Select a pick to see the denier'; ?>
                    </div>
                    <?php
                        echo $this->Form->control('quantity', ['label' => 'Quantity (Meter)']);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#pick-id').on('change', function() {
        var pickId = $(this).val();
        var denierDisplay = $('#denier-display');

        if (pickId) {
            $.ajax({
                url: '<?php echo $this->Url->build(['controller' => 'Waterjets', 'action' => 'getDeniersByPick']); ?>/' + pickId,
                method: 'GET',
                success: function(response) {
                    var deniers = JSON.parse(response);
                    var denierValue = Object.values(deniers)[0] || 'Not found'; // Get the first denier value or 'Not found'
                    denierDisplay.text('Denier: ' + denierValue);
                },
                error: function() {
                    alert('Error fetching deniers. Please try again.');
                }
            });
        } else {
            denierDisplay.text('Select a pick to see the denier');
        }
    });
});
</script>
