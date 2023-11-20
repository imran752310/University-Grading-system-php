<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
$teacher_id = $_SESSION['id'];
?>

<!-- -============Selection code ===========--->
<?php
$sno = 1;
$select_query = "
SELECT course_tbl.*, dept_tbl.title, batch_tbl.batch_name
FROM course_tbl
INNER JOIN batch_tbl ON course_tbl.batch_id = batch_tbl.batch_id
INNER JOIN dept_tbl ON dept_tbl.dept_id = batch_tbl.dept_id
WHERE course_tbl.teacher_id = $teacher_id
";

$subject_list_res = mysqli_query($conn, $select_query);
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">All Subjects</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S no</th>
                                    <th>Subject</th>
                                    <th>Batch</th>
                                    <th>Assigments</th>
                                    <th>Attendance</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($course = mysqli_fetch_array($subject_list_res)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $course[1] ?></td>
                                    <td><?php echo $course['title'] . " - " . $course['batch_name'] ?></td>
                                    <td>
                                        <a href="assignments.php?course_id=<?php echo $course['course_id'] ?>"
                                            class="btn btn-success">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="attendance.php?course_id=<?php echo $course['course_id'] ?>"
                                            class="btn btn-primary">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="result.php?course_id=<?php echo $course['course_id'] ?>"
                                            class="btn btn-warning">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>


                            </tbody>
                        </table>
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