<section class="content-header">
    <h1>
        After Dispatch Report (Stock Balance)
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Length and Design Report</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Length (cm)</th>
                                <th>Design Name</th>
                                <th>Calculated Result</th>
                                <th>Remaining Rolls Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lengths as $index => $length): ?>
                                <tr>
                                    <td><?php echo h($length); ?></td>
                                    <td><?php echo h($designNames[$index]); ?></td>
                                    <td><?php echo h($calculatedResults[$index]); ?></td>
                                    <td><?php echo h($remainingRolls[$index]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
