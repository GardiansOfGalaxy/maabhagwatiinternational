<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
   Report

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<section class="content">

<div class="grey-production-report">
    <h2>Grey Production Report</h2>
    <form method="get" class="date-form">
        <label for="startDate">Date From:</label>
        <input type="date" name="startDate" id="startDate" value="<?= $this->request->getQuery('startDate') ?>">
        <label for="endDate">Date To:</label>
        <input type="date" name="endDate" id="endDate" value="<?= $this->request->getQuery('endDate') ?>">
        <button type="submit" class="btn btn-success">OK</button>
    </form>

    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Pick</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData as $row): ?>
                <tr>
                    <td><?= h($row['date']) ?></td>
                    <td><?= h($row['pick']) ?></td>
                    <td><?= h($row['quantity']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
   .grey-production-report {
    font-family: Arial, sans-serif;
    margin: 20px;
}

.grey-production-report h2 {
    color: #5bc0de;
    text-align: center;
}

.date-form {
    display: flex;
    flex-wrap: wrap; /* Allows wrapping of items to next line */
    justify-content: center; /* Centers the items horizontally */
    align-items: center;
    margin-bottom: 20px;
}

.date-form label {
    margin: 0 10px;
    white-space: nowrap; /* Prevents label text from wrapping */
}

.date-form input {
    margin: 0 5px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.date-form button {
    margin: 0 5px;
    padding: 8px 15px;
    background-color: #5cb85c;
    border: none;
    border-radius: 4px;
    color: white;
    cursor: pointer;
}

.date-form button:hover {
    background-color: #4cae4c;
}

.table-container {
    display: flex;
    justify-content: center;
    overflow-x: auto; /* Handles overflow for smaller screens */
}

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
    border: 2px solid #000; /* Added border to the table */

}

.table th {
    background-color: #5bc0de; /* Highlighted top bar */
    color: white; /* White text for better contrast */
    border: 2px solid #000; /* Added border to the table */

}

.table tbody tr:hover {
    background-color: #f9f9f9;
}

.table tbody tr td:nth-child(2), .table tbody tr td:nth-child(3) {
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .date-form {
        flex-direction: column; /* Stacks items vertically */
        align-items: stretch;
    }
    .date-form label,
    .date-form input,
    .date-form button {
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
