<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');

if (!isset($_GET['std_id']) || !is_numeric($_GET['std_id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$std_id = $_GET['std_id'];
$current_url = 'student.php?std_id=' . $std_id . '&dept_id=' . $_GET['dept_id'] . '&batch_id=' . $_GET['batch_id'];
$back = 'students.php?dept_id=' . $_GET['dept_id'] . '&batch_id=' . $_GET['batch_id'];
?>

<!--================ Insertipion Code============= -->
<?php
if (isset($_POST['add_course'])) :
    $course_id = $_POST['course'];
    $stdudent_id = $_POST['std_id'];
    $std_crs_id = date('Y-m-d H:i:s');
    $query = "INSERT INTO student_course_tbl(student_course_id, course_id, student_id) VALUES('$std_crs_id','$course_id','$stdudent_id')";
    $run = mysqli_query($conn, $query);
?>
<div class="container">
    <?php if ($run) :
            $latestId = mysqli_insert_id($conn);
            $result_query = "INSERT INTO result_tbl(student_course_id) VALUES('$std_crs_id')";
            mysqli_query($conn, $result_query);

        ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Subject added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add subject, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php
endif;
?>
<!--================ Insertipion Code end============= -->

<!--================ Delete Code============= -->
<?php
if (isset($_GET['del_id'])) :
    $del_id = $_GET['del_id'];
    $del_query = "DELETE FROM student_course_tbl WHERE student_course_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) :
            $result_delete_query = "DELETE FROM result_tbl WHERE student_course_id = '$del_id'";
            mysqli_query($conn, $result_delete_query);
        ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Subject deleted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete subject, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->


<!--================ Selection Code============= -->
<?php
$sno = 1;
$select_student_query = "SELECT name, batch_id FROM student_tbl WHERE std_id = '$std_id'";
$select_query = "SELECT student_course_tbl.*, student_tbl.name, course_tbl.title
                        FROM student_course_tbl
                        INNER JOIN course_tbl ON student_course_tbl.course_id = course_tbl.course_id
                        INNER JOIN student_tbl ON student_course_tbl.student_id = student_tbl.std_id
                        WHERE student_course_tbl.student_id = $std_id";
$select_result = mysqli_query($conn, $select_query);

$std_res = mysqli_query($conn, $select_student_query);
if (mysqli_num_rows($std_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$std_arr = mysqli_fetch_array($std_res);
$std_name = $std_arr['name'];
$std_batch = $std_arr['batch_id'];


// select courses for dropdown
$course_query = "SELECT course_id, title, semester FROM course_tbl WHERE batch_id = $std_batch";
$course_result = mysqli_query($conn, $course_query);

?>
<!--================ Selection Code end============= -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <div class="row">
                        <div class="col flex-grow-0">
                            <a href="<?php echo $back; ?>" class="text-primary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                        <div class="col flex-grow-1">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $std_name; ?> - Subjects List</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($std_course = mysqli_fetch_array($select_result)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $std_course['title'] ?></td>
                                    <td>
                                        <a href="<?php echo $current_url . "&del_id=" . $std_course['student_course_id'] ?>"
                                            onclick="return confirm('Are you sure to delete the selected course?')"
                                            class="btn btn-danger">
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

        <div class="col-xl-4">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Subject</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="<?php echo $current_url; ?>">
                            <input type="hidden" id="std_id" name="std_id" value="<?php echo $std_id; ?>" />
                            <select id="course" name="course" class="form-control">
                                <option value="select_subject">Select Subject</option>
                                <?php while ($course = mysqli_fetch_array($course_result)) : ?>
                                <option value="<?php echo $course['course_id']  ?>"><?php echo $course['title']  ?>
                                    (<?php echo $course['semester']  ?>) </option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" class="btn btn-primary mt-4" name="add_course">Add Subject</button>
                        </form>
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