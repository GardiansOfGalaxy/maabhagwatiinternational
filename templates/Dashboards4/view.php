<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Report</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <h2 class="text-center">Used Quantity Report</h2>
                <form id="mainForm" method="get" class="text-center mt-4" action="<?= $this->Url->build(['action' => 'view']); ?>">
                    <!-- Width Dropdown -->
                    <div class="form-group row text-center ">
                        <div class="col-12 col-md-6 mx-auto text-center mt-4">
                            <?= $this->Form->control('width_id', [
                                'options' => $widths,
                                'label' => 'Width:',
                                'id' => 'width-id',
                                'class' => 'form-control',
                                'empty' => '-- Select Width --'
                            ]); ?>
                        </div>
                    </div>

                    <!-- Pick Dropdown -->
                    <div class="form-group row">
                        <div class="col-12 col-md-6 mx-auto">
                            <?= $this->Form->control('pick_id', [
                                'options' => [],
                                'label' => 'Pick:',
                                'id' => 'pick-id',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                    </div>

                    <!-- Denier Dropdown -->
                    <div class="form-group row">
                        <div class="col-12 col-md-6 mx-auto">
                            <?= $this->Form->control('denier_id', [
                                'options' => [],
                                'label' => 'Denier:',
                                'id' => 'denier-id',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                    </div>

                    <!-- Date Range Inputs -->
                    <div class="form-group row">
                        <div class="col-12 col-md-3 mb-3">
                            <?= $this->Form->control('start_date', [
                                'label' => 'Start Date:',
                                'type' => 'date',
                                'required' => true,
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <?= $this->Form->control('end_date', [
                                'label' => 'End Date:',
                                'type' => 'date',
                                'required' => true,
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-12 col-md-3 mx-auto">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Submit</button>
                        </div>
                    </div>
                </form>

                <!-- Report Table -->
                <div id="reportTable">
                    <?php if (!empty($calculatedData)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Pick</th>
                                        <th class="text-center">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($calculatedData as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= h($row['pick']); ?></td>
                                            <td class="text-center"><?= h($row['data']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <p class="text-center">No data available for the selected date range.</p>
                    <?php endif; ?>
                </div>

                <!-- Result Section -->
                <div id="resultContainer" class="text-center mt-4">
                    <h3>Calculation Result:</h3>
                    <p id="resultText">Please submit the form to see the result.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    /* Centering the content */
    .ceter {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        /* Full height */
        width: 100%;
    }

    .justify-content-center {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
    }

    /* Move content closer to the top */
    .top-position {
        margin-top: -290px;
        /* Adjust this value to move the form further up */
    }

    /* Making the input boxes larger */
    .form-control-lg {
        font-size: 1.5rem;
        /* Increase font size */
        padding: 15px;
        /* Larger padding */
    }

    /* Button adjustments */
    .btn-lg {
        padding: 15px 30px;
        font-size: 1.5rem;
    }

    h2 {
        color: #5bc0de;
    }

    /* Adjust form container */
    .col-md-8 {
        /* max-width: 600px; Narrow the max width for better centering */
    }

    /* Table styling */
    .table-container {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
        /* Add space between form and table */
    }

    .table {
        width: 100%;
        max-width: 1200px;
        border-collapse: collapse;
        border: 2px solid #000;
    }

    .table th,
    /* Move content closer to the top */
.top-position {
    margin-top: -50px; /* Adjust for smaller screens */
}
@media (min-width: 991px) {
    .form-group{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
    }
}
/* Responsive adjustments */
@media (max-width: 768px) {
    .top-position {
        margin-top: 0;
    }

    .form-control-lg {
        font-size: 1rem;
        padding: 10px;
    }

    .btn-lg {
        font-size: 1rem;
        padding: 10px 20px;
    }
}

@media (min-width: 992px) {
    .top-position {
        margin-top: -290px; /* Adjust for larger screens */
    }

    .form-control-lg {
        font-size: 1.5rem;
        padding: 15px;
    }

    .btn-lg {
        font-size: 1.5rem;
        padding: 15px 30px;
    }
}

/* Table Styling */
.table-responsive {
    margin-top: 20px;
}

.table th,
.table td {
    border: 1px solid #000;
    padding: 12px;
    text-align: center;
}

.table th {
    background-color: #5bc0de;
    color: white;
}

.table tbody tr:hover {
    background-color: #f9f9f9;
}

/* Centering container */
.container-fluid {
    padding: 0 15px;
}

/* Adjust for smaller screens */
@media (max-width: 576px) {
    .form-control {
        width: 100%;
    }

    .btn-block {
        width: 100%;
    }
}

</style>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#width-id').change(function() {
            var widthId = $(this).val();

            if (widthId) {
                $.ajax({
                    url: '<?= $this->Url->build(['controller' => 'Dashboards4', 'action' => 'getPicksAndDeniersByWidth']) ?>/' + widthId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Data received for picks and deniers:', data); // Debugging

                        if (data.picks && data.deniers) {
                            var pickSelect = $('#pick-id');
                            var denierSelect = $('#denier-id');
                            pickSelect.empty(); // Clear previous options
                            denierSelect.empty(); // Clear previous options

                            $.each(data.picks, function(key, value) {
                                pickSelect.append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                            });

                            $.each(data.deniers, function(key, value) {
                                denierSelect.append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                            });
                        } else {
                            console.error('Invalid data format:', data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching picks and deniers:', status, error);
                        alert('Unable to load pick and denier options.');
                    }
                });
            }
        });

        $('#mainForm').submit(function(event) {
            event.preventDefault();

            var widthId = $('#width-id').val();
            var pickId = $('#pick-id').val();
            var denierId = $('#denier-id').val();
            var startDate = $('[name="start_date"]').val();
            var endDate = $('[name="end_date"]').val();

            if (widthId && pickId && denierId && startDate && endDate) {
                $.ajax({
                    url: '<?= $this->Url->build(['controller' => 'Dashboards4', 'action' => 'calculateReport']) ?>/' + widthId + '/' + pickId + '/' + denierId,
                    type: 'GET',
                    data: {
                        width_id: widthId,
                        pick_id: pickId,
                        denier_id: denierId,
                        start_date: startDate,
                        end_date: endDate
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.result) {
                            $('#resultText').text(data.result.toFixed(2) + ' kg/m');
                        } else {
                            $('#resultText').text('Error in calculation Or Quantity is not available fot pick');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#resultText').text('Unable to perform calculation.');
                    }
                });
            } else {
                $('#resultText').text('Please select all options and date range.');
            }
        });

    });
</script>