<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');


if (!isset($_GET['course_id']) || !isset($_GET['date']) || !is_numeric($_GET['course_id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}
$course_id = $_GET['course_id'];
$date = $_GET['date'];
$current_url = 'view-attendance.php?course_id=' . $course_id . '&date=' . $date;
?>

<!---==========Delete Code==========--->
<?php
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $query = "DELETE from attendance_tbl where student_course_id='$id'";
    $run = mysqli_query($conn, $query);
    if ($run) {

?>
<div class="col-xl-6 ">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Student Delete successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php
    }
}
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

$attendance_query = "SELECT attendance_tbl.status, attendance_tbl.student_course_id, student_tbl.std_id, student_tbl.name FROM attendance_tbl 
                    INNER JOIN student_course_tbl ON student_course_tbl.student_course_id = attendance_tbl.student_course_id
                    INNER JOIN student_tbl ON student_tbl.std_id = student_course_tbl.student_id
                    WHERE student_course_tbl.course_id = '$course_id' AND date = '$date'";
$attendance_res = mysqli_query($conn, $attendance_query);

?>

<div class="container-fluid">
    <div class="card shadow mb-4" >
        <div class="card-header py-3" >
            <div class="row">
                <div class="col flex-grow-0">
                    <a href="attendance.php?course_id=<?php echo $course_id ?>" class="text-primary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="col flex-grow-1">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title ?> - Attendance |
                        <?php echo $date; ?></h6>
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($attendance = mysqli_fetch_array($attendance_res)) : ?>
                            <tr>
                                <td><?php echo $sno++ ?></td>
                                <td><?php echo $attendance['name'] ?></td>
                                <td><?php echo $attendance['status'] ?></td>
                                <td>
                                    <a href="<?php echo $current_url . '&edit_id=' . $attendance['student_course_id']; ?>"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
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

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>