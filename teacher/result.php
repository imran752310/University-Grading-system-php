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
$current_url = 'result.php?course_id=' . $course_id;
?>

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['update_result'])) :
    $success = true;
    $res_select_query = "SELECT result_tbl.result_id
                    FROM result_tbl
                    INNER JOIN student_course_tbl ON result_tbl.student_course_id = student_course_tbl.student_course_id
                    WHERE student_course_tbl.course_id = '$course_id'";

    $result_id_res = mysqli_query($conn, $res_select_query);
    while ($result = mysqli_fetch_array($result_id_res)) {
        $res_id = (int)$result['result_id'];
        $mid = (int)$_POST['mid-' . $res_id];
        $assignment = (int)$_POST['assignment-' . $res_id];
        $quiz = (int)$_POST['quiz-' . $res_id];
        $final = (int)$_POST['final-' . $res_id];
        $status = isset($_POST['status-' . $res_id]) ? 1 : 0;
        $query = "UPDATE result_tbl SET mid_marks = '$mid', assigment_m = '$assignment', quizz_marks = '$quiz', final_marks = '$final', show_status = '$status'
       WHERE result_id = '$res_id'";
        $run = mysqli_query($conn, $query);
        if (!$run) $success = false;
    }
?>

<div class="container">
    <?php if ($success) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Result updated successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Some marks might not be updated successfuly!
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
$course_query = "SELECT course_tbl.title FROM course_tbl
                WHERE course_id = '$course_id' AND teacher_id = " . $_SESSION['id'];
$course_res = mysqli_query($conn, $course_query);
if (mysqli_num_rows($course_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}
$course_title = mysqli_fetch_array($course_res)['title'];

$res_select_query = "SELECT student_tbl.name, result_tbl.*
                    FROM student_tbl
                    INNER JOIN student_course_tbl ON student_tbl.std_id = student_course_tbl.student_id
                    INNER JOIN result_tbl ON result_tbl.student_course_id = student_course_tbl.student_course_id
                    WHERE student_course_tbl.course_id = '$course_id'";


$result_res = mysqli_query($conn, $res_select_query);
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-primary">
            <h3>Grading Scheme</h3>
            <?php
            $q = mysqli_query($conn, "SELECT * FROM grading_tbl");
            while ($r = mysqli_fetch_array($q)) {

            ?>
            <tr>
                <td> <?php echo $r['title']; ?> : <?php echo $r['marks']; ?> </td>

            </tr>&nbsp;&nbsp;&nbsp;

            <?php } ?>
        </div>
    </div>
    <div class="card shadow mb-4" >
        <div class="card-header py-3" >
            <div class="row">
                <div class="col flex-grow-0">
                    <a href="index.php" class="text-primary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="col flex-grow-1">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title; ?> - Result</h6>
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
                                <th>Mid</th>
                                <th>Assignment</th>
                                <th>Quiz</th>
                                <th>Final</th>
                                <th>Show</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="<?php echo $current_url; ?>" method="post">
                                <?php while ($result = mysqli_fetch_array($result_res)) : ?>
                                <input type="hidden" name="id-<?php echo $result['result_id'] ?>"
                                    value="<?php echo $result['result_id'] ?>" />
                                <tr>

                                    <td><?php echo $sno++; ?></td>
                                    <td><?php echo $result['name'] ?></td>
                                    <td>
                                        <input name="mid-<?php echo $result['result_id'] ?>"
                                            value="<?php echo $result['mid_marks'] ?>" class="form-control" required />
                                    </td>
                                    <td>
                                        <input name="assignment-<?php echo $result['result_id'] ?>"
                                            value="<?php echo $result['assigment_m'] ?>" class="form-control"
                                            required />
                                    </td>
                                    <td>
                                        <input name="quiz-<?php echo $result['result_id'] ?>"
                                            value="<?php echo $result['quizz_marks'] ?>" class="form-control"
                                            required />
                                    </td>
                                    <td>
                                        <input name="final-<?php echo $result['result_id'] ?>"
                                            value="<?php echo $result['final_marks'] ?>" class="form-control"
                                            required />
                                    </td>
                                    <td>
                                        <input type="checkbox" name="status-<?php echo $result['result_id'] ?>"
                                            class="form-check-input"
                                            <?php echo ($result['show_status'] == 1) ? 'checked' : ''; ?> />
                                    </td>
                                    <td>
                                        <?php echo $result['mid_marks'] + $result['assigment_m'] + $result['quizz_marks'] + $result['final_marks'] ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <tr>
                                    <td colspan="8">
                                        <input type="submit" class="btn btn-primary" value="Update Result"
                                            name="update_result" />
                                    </td>
                                </tr>
                            </form>
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