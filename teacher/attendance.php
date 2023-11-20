<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');


if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}
$course_id = $_GET['course_id'];
$current_url = 'attendance.php?course_id=' . $course_id;
?>


<!---============Selection code ===========--->
<?php
$sno = 1;
$course_query = "SELECT * FROM course_tbl WHERE course_id = '$course_id' AND teacher_id = " . $_SESSION['id'];
$course_res = mysqli_query($conn, $course_query);
if (mysqli_num_rows($course_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}
$course_title = mysqli_fetch_array($course_res)['title'];

$select_query = "SELECT DISTINCT a.`date`
FROM `attendance_tbl` a
JOIN `student_course_tbl` sc ON a.`student_course_id` = sc.`student_course_id`
WHERE sc.`course_id` = $course_id
ORDER BY a.`date`";;

$attendance_res = mysqli_query($conn, $select_query);
?>

<div class="container-fluid">
    <div class="card shadow mb-4" >
        <div class="card-header py-3" >
            <div class="row">
                <div class="col flex-grow-0">
                    <a href="index.php" class="text-primary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="col flex-grow-1">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title; ?> - Attendance</h6>
                </div>
                <div class="col flex-grow-0">
                    <!-- Add attendance -->
                    <a href="<?php echo "add-attendance.php?course_id=$course_id" ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S no</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($attendance = mysqli_fetch_array($attendance_res)) : ?>
                            <tr>
                                <td><?php echo $sno++ ?></td>
                                <td><?php echo $attendance['date'] ?></td>
                                <td>
                                    <a href="<?php echo "view-attendance.php?course_id=$course_id&date=" . $attendance['date']; ?>"
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