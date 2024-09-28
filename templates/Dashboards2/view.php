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
<section class="content">
<div class="ceter">
    <div class="justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center">Grey Remaning Report</h2>
            <form id="dateForm" method="get" action="<?= $this->Url->build(['action' => 'view']); ?>">
                <div class="row mb-3 justify-content-center">
                    <div class="col-md-3">
                        <label for="startDate">Date From:</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" value="<?= h($this->request->getQuery('startDate')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="endDate">Date To:</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" value="<?= h($this->request->getQuery('endDate')); ?>">
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-success btn-block">OK</button>
                    </div>
                </div>
            </form>

            <div id="reportTable">
                <?php if (!empty($calculatedData)) : ?>
                    <div class="table-container">

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
                    <?php else : ?>
                        <p class="text-center">No data available for the selected date range.</p>
                    <?php endif; ?>
                    </div>
            </div>

        </div>
    </div>
    </div>
    </section>
</section>

<?php echo $this->Html->css('AdminLTE./bower_components/morris.js/morris', ['block' => 'css']); ?>
<?php echo $this->Html->css('AdminLTE./bower_components/jvectormap/jquery-jvectormap', ['block' => 'css']); ?>
<?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min', ['block' => 'css']); ?>
<?php echo $this->Html->css('AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker', ['block' => 'css']); ?>
<?php echo $this->Html->css('AdminLTE./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min', ['block' => 'css']); ?>

<?php echo $this->Html->script('AdminLTE./bower_components/jquery-ui/jquery-ui.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/raphael/raphael.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/morris.js/morris.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/jquery-sparkline/dist/jquery.sparkline.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/jvectormap/jquery-jvectormap-1.2.2.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/jvectormap/jquery-jvectormap-world-mill-en', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/jquery-knob/dist/jquery.knob.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/moment/min/moment.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE.pages/dashboard', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE.demo', ['block' => 'script']); ?>

<?php $this->start('scriptBottom'); ?>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<?php $this->end(); ?>

<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
   /* Center content with flexbox */
.ceter {
    display: flex;
    justify-content: center;
    width: 100%;
}

/* Center content within .justify-content-center and align to the right */
.justify-content-center {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}
.justify-content-center h2 {
    color: #5bc0de;}
.col-md-8 {
    margin-left: auto;
    margin-right: auto;
    max-width: 800px; /* Adjust as needed */
}

/* Center table within .table-container */
.table-container {
    display: flex;
    justify-content: center;
    width: 100%;
}

/* Table styling */
.table {
    width: 100%;
    max-width: 1200px; /* Increased maximum width for larger screens */
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 2px solid #000; /* Added border to the table */
}

.table th, .table td {
    border: 1px solid #000; /* Added border to table cells */
    padding: 12px; /* Slightly increased padding for better readability */
    text-align: center;
}

.table th {
    background-color: #5bc0de; /* Highlighted top bar */
    color: white; /* White text for better contrast */
}

.table tbody tr:hover {
    background-color: #f9f9f9;
}

.table tbody tr td:nth-child(2), .table tbody tr td:nth-child(3) {
    font-weight: bold;
}

/* Form styling */
#dateForm .row {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}

#dateForm label {
    margin-right: 10px;
    white-space: nowrap;
}

#dateForm input,
#dateForm button {
    margin: 0 5px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

#dateForm button {
    background-color: #5cb85c;
    color: white;
    cursor: pointer;
}

#dateForm button:hover {
    background-color: #4cae4c;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #dateForm .row {
        flex-direction: column;
        align-items: stretch;
    }

    #dateForm label,
    #dateForm input,
    #dateForm button {
        margin: 5px 0;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .table th, .table td {
        font-size: 14px; /* Reduce font size on very small screens */
        padding: 8px; /* Adjust padding for smaller screens */
    }
}

</style>
