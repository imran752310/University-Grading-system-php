<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
$std_id =  $_SESSION['id'];
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-xl-10   ">
            <div class="card shadow mb-4" style="border-radius: 40px;">
                <div class="card-header py-3" style="border-radius: 40px;">
                    <h6 class="m-0 font-weight-bold text-primary">Fee Record</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S no</th>
                                    <th>Semester Name</th>

                                    <th>Amount</th>

                                    <th>Date</th>


                                </tr>
                            </thead>
                            <tbody>
                                <!---============Selection code ===========--->
                                <?php
                                $sno = 1;
                                $select_query = "SELECT * FROM student_fee_tbl where std_id='$std_id'";
                                $execte = mysqli_query($conn, $select_query);
                                while ($data = mysqli_fetch_array($execte)) {
                                ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>

                                    <td><?php echo $data[2] ?></td>
                                    <td><?php echo $data[3] ?></td>
                                    <td><?php echo $data[4] ?></td>
                                </tr>
                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>



</div>



<?php

include('includes/scripts.php');
include('includes/footer.php');
?>