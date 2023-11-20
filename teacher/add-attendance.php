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
$current_url = 'add-attendance.php?course_id=' . $course_id;
?>

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['mark_attendance'])) :
    $date = $_POST['date'];
    $course_id = $_POST['course_id'];
    $success = true;

    $select_std_query = "SELECT student_tbl.std_id, student_course_tbl.student_course_id FROM student_tbl
                    INNER JOIN student_course_tbl ON student_course_tbl.student_id = student_tbl.std_id
                    WHERE student_course_tbl.course_id = '$course_id'";
    $std_id_res = mysqli_query($conn, $select_std_query);
    while ($std = mysqli_fetch_array($std_id_res)) {
        $student_id = $std['std_id'];
        $std_crs_id = $std['student_course_id'];
        $status = $_POST['status-' . $student_id];
        $query = "INSERT INTO attendance_tbl (student_course_id, date, status)
                 VALUES ('$std_crs_id', '$date', '$status')";
        $run = mysqli_query($conn, $query);
        if (!$run) $success = false;
    }
    unset($_POST['mark_attendance']);
?>

<div class="container">
    <?php if ($success) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Attendance added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Some attendance might not be added successfuly!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!--================ Insertion Code End============= -->


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

$select_std_query = "SELECT student_tbl.name, student_tbl.std_id FROM student_tbl
                    INNER JOIN student_course_tbl ON student_course_tbl.student_id = student_tbl.std_id
                    WHERE student_course_tbl.course_id = '$course_id'";
$std_select_res = mysqli_query($conn, $select_std_query);
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" >
            <div class="row">
                <div class="col flex-grow-0">
                    <a href="attendance.php?course_id=<?php echo $course_id; ?>" class="text-primary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="col flex-grow-1">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title; ?> - Mark Attendance</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?php echo $current_url; ?>" method="post">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                <div class="form-group row">
                    <div class="col-6 col-md-3">
                        <input id="date" name="date" type="date" class="form-control" required />
                    </div>
                </div>

                <?php while ($std = mysqli_fetch_array($std_select_res)) : ?>
                <div class="form-group row border-bottom">
                    <div class="col flex-grow-0"><?php echo $sno < 10 ? '0' . $sno++ : $sno++ ?>.</div>
                    <div class="col-3">
                        <label for="student"><?php echo $std['name'] ?></label>
                        <input type="hidden" name="student_id" value="<?php echo $std['std_id'] ?>" />
                    </div>
                    <div class="col">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="status-<?php echo $std['std_id'] ?>" value="P"
                                id="present-<?php echo $std['std_id'] ?>" class="custom-control-input" required>
                            <label for="present-<?php echo $std['std_id'] ?>"
                                class="custom-control-label">Present</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="status-<?php echo $std['std_id'] ?>" value="A"
                                id="absent-<?php echo $std['std_id'] ?>" class="custom-control-input" required>
                            <label for="absent-<?php echo $std['std_id'] ?>" class="custom-control-label">Absent</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="status-<?php echo $std['std_id'] ?>" value="L"
                                id="Leave-<?php echo $std['std_id'] ?>" class="custom-control-input" required>
                            <label for="Leave-<?php echo $std['std_id'] ?>" class="custom-control-label">Leave</label>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                <button class="btn btn-primary" name="mark_attendance">Mark Attendance</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>