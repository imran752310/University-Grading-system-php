<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');

$id = $_SESSION['id'];
?>



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-md-8 mb-4">
            <div class="row">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-5">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-4">
                                        Hi <?php echo $_SESSION['name']; ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Welcome to Your Dashboard </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-university fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-5">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-4">
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Your have Assign
                                        <?php
                                        $query = "SELECT * FROM course_tbl where teacher_id='$id'";
                                        $query_run = mysqli_query($conn, $query);
                                        $row = mysqli_num_rows($query_run);
                                        echo '' . $row . '';
                                        ?>
                                        Subjects
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-university fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>






    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php

include('includes/scripts.php');
include('includes/footer.php');

?>