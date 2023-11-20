<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>


<!---============Selection code ===========--->
<?php
$sno = 1;
$std_id = $_SESSION['id'];
$courses_query = "SELECT * FROM course_tbl
                INNER JOIN student_course_tbl ON student_course_tbl.course_id = course_tbl.course_id
                WHERE student_course_tbl.student_id = '$std_id'";
$courses_res = mysqli_query($conn, $courses_query);
?>

<div class="container-fluid">
    <div class="card shadow mb-4" style="border-radius: 40px;">
        <div class="card-header py-3" style="border-radius: 40px;">
            <h6 class="m-0 font-weight-bold text-primary">Attendance</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S no</th>
                                <th>Course Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($course = mysqli_fetch_array($courses_res)) : ?>
                            <tr>
                                <td><?php echo $sno++ ?></td>
                                <td><?php echo $course['title'] ?></td>
                                <td>
                                    <a href="<?php echo 'view-attendance.php?course_id=' . $course['course_id']; ?>"
                                        class="btn btn-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>