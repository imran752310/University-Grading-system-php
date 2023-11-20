<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');


if (!isset($_GET['batch_id']) || !is_numeric($_GET['batch_id']) || !isset($_GET['dept_id']) || !is_numeric($_GET['dept_id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$batch_id = $_GET['batch_id'];
$current_url = 'courses.php?dept_id=' . $_GET['dept_id'] . '&batch_id=' . $batch_id;
$back_url = "department.php?id=" . $_GET['dept_id'];
?>


<!--================ Insertipion Code============= -->

<?php
if (isset($_POST['add_course'])) :
    $title = $_POST['title'];
    $marks = $_POST['marks'];
    $chr = $_POST['chr'];
    $teacher = $_POST['teacher'];
    $batch = $_POST['batch'];

    $semester = $_POST['semester'];

    $query = "INSERT INTO course_tbl(title, batch_id, total_marks, chr, teacher_id, semester) VALUES('$title','$batch','$marks','$chr', '$teacher','$semester')";
    $run = mysqli_query($conn, $query);
?>
<div class="container">
    <?php if ($run) : ?>

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
    $del_query = "DELETE FROM course_tbl WHERE course_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
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

<!--================ update Code============= -->

<?php
if (isset($_POST['update_course'])) :
    $update_id =    $_POST['update_id'];
    $update_title = $_POST['update_title'];
    $update_marks = $_POST['update_marks'];
    $update_chr = $_POST['update_chr'];
    $update_teacher = $_POST['update_teacher'];


    $query = "UPDATE course_tbl SET title='$update_title',total_marks='$update_marks', chr='$update_chr', teacher_id='$update_teacher' where course_id ='$update_id'";

    $run = mysqli_query($conn, $query);
?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Subject Update successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add Update, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php
endif;
?>

<!--================ Selection============= -->
<?php
$sno = 1;
$select_dept_title = "SELECT title FROM dept_tbl WHERE dept_id =" . $_GET['dept_id'];
$select_batch_name = "SELECT batch_name FROM batch_tbl WHERE batch_id =" . $_GET['batch_id'];
$select_query = "SELECT course_tbl.* , teacher_tbl.teacher_id, teacher_tbl.name FROM course_tbl INNER JOIN teacher_tbl WHERE course_tbl.teacher_id = teacher_tbl.teacher_id AND course_tbl.batch_id = '$batch_id'";

$dept_title_res = mysqli_query($conn, $select_dept_title);
$batch_name_res = mysqli_query($conn, $select_batch_name);
if (mysqli_num_rows($dept_title_res) == 0 || mysqli_num_rows($batch_name_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}

$dept = mysqli_fetch_array($dept_title_res)['title'];
$batch = mysqli_fetch_array($batch_name_res)['batch_name'];
$courses = mysqli_query($conn, $select_query);

// For teacher dropdown
$select_teacher_query = "SELECT teacher_id, name FROM teacher_tbl";
$teacher_name_res = mysqli_query($conn, $select_teacher_query);

?>
<!--================ Selection end============= -->


<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <div class="row">
                        <div class="col-flex-grow-0">
                            <a href="<?php echo $back_url ?>" class="text-primary btn">
                                <i class="fa-fa arrow-left">
                                    <- </a>
                        </div>
                        <div class="col-flex-grow-1">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $dept; ?> - All Subjects</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Batch</th>
                                    <th>Teacher</th>
                                    <th>Total Marks & Credit Hrs</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($course = mysqli_fetch_array($courses)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $course['title'] ?> (<?php echo $course['semester'] ?>) </td>
                                    <td><?php echo $dept . " - " . $batch  ?></td>
                                    <td><?php echo $course['name'] ?></td>
                                    <td><?php echo $course['total_marks'] . " / " . $course['chr'] ?></td>
                                    <td>
                                        <a href="<?php echo $current_url . "&edit_id=" . $course['course_id'] ?>"
                                            class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="<?php echo $current_url . "&del_id=" . $course['course_id'] ?>"
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
            <?php
            if (isset($_GET['edit_id'])) :
                $course_id = $_GET['edit_id'];
                $execut = mysqli_query($conn, "SELECT * FROM course_tbl where course_id='$course_id'");
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Subject</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="<?php echo $current_url; ?>">
                            <?php
                                while ($course_data = mysqli_fetch_array($execut)) :
                                ?>
                            <label for="address">Semester</label>
                            <select id="teacher" name="update_semester" class="form-control">
                                <option value="<?php echo $course_data['semester'] ?>">
                                    <?php echo $course_data['semester'] ?></option>
                                <option value="semester 1">ist semester</option>
                                <option value="semester 2">2nd semester</option>
                                <option value="semester 3">3rd semester</option>
                                <option value="semester 4">4th semester</option>
                                <option value="semester 5">5th semester</option>
                                <option value="semester 6">6th semester</option>
                                <option value="semester 7">7th semester</option>
                                <option value="semester 8">8th semester</option>
                            </select>
                            <label for="name">Course Title</label>
                            <input id="name" type="hidden" name="update_id" value="<?php echo $course_data['0'] ?>" />
                            <input id="name" name="update_title" value="<?php echo $course_data['1'] ?>"
                                autocomplete="off" class="form-control" required placeholder="Enter subject title" />
                            <label for="marks">Total Marks</label>
                            <input type="number" id="marks" value="<?php echo $course_data['3'] ?>" name="update_marks"
                                autocomplete="off" class="form-control" required placeholder="Enter total marks" />
                            <label for="chr">Credit Hours</label>
                            <input type="number" id="chr" name="update_chr" value="<?php echo $course_data['4'] ?>"
                                autocomplete="off" class="form-control" required
                                placeholder="Enter total credit hours" />

                            <label for="teacher">Teacher</label>
                            <select id="teacher" name="update_teacher" class="form-control">
                                <option value="<?php echo $course_data['5'] ?>"><?php
                                                                                        $id = $course_data['5'];
                                                                                        $ext = mysqli_query($conn, "SELECT* FROM teacher_tbl where teacher_id='$id'");
                                                                                        $teacher = mysqli_fetch_array($ext);
                                                                                        $teacher['1']; ?></option>
                                <?php while ($teacher = mysqli_fetch_array($teacher_name_res)) : ?>
                                <option value="<?php echo $teacher['teacher_id']  ?>"><?php echo $teacher['name']  ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                            <?php endwhile; ?>
                            <button type="submit" class="btn btn-primary mt-4" name="update_course">Update
                                Subject</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            else :

            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Subject</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="<?php echo $current_url; ?>">
                            <label for="address">Semester</label>
                            <select id="teacher" name="semester" class="form-control">
                                <option>....Select semester....</option>
                                <option value="semester 1">ist semester</option>
                                <option value="semester 2">2nd semester</option>
                                <option value="semester 3">3rd semester</option>
                                <option value="semester 4">4th semester</option>
                                <option value="semester 5">5th semester</option>
                                <option value="semester 6">6th semester</option>
                                <option value="semester 7">7th semester</option>
                                <option value="semester 8">8th semester</option>
                            </select>
                            <label for="name">Course Title</label>
                            <input id="name" name="title" autocomplete="off" class="form-control" required
                                placeholder="Enter subject title" />
                            <label for="marks">Total Marks</label>
                            <input type="number" id="marks" name="marks" autocomplete="off" class="form-control"
                                required placeholder="Enter total marks" />
                            <label for="chr">Credit Hours</label>
                            <input type="number" id="chr" name="chr" autocomplete="off" class="form-control" required
                                placeholder="Enter total credit hours" />
                            <input type="hidden" value="<?php echo $batch_id; ?>" id="batch" name="batch"
                                autocomplete="off" class="form-control" required placeholder="Enter batch id" />
                            <label for="teacher">Teacher</label>
                            <select id="teacher" name="teacher" class="form-control">
                                <option value="select_teacher">Select Teacher</option>
                                <?php while ($teacher = mysqli_fetch_array($teacher_name_res)) : ?>
                                <option value="<?php echo $teacher['teacher_id']  ?>"><?php echo $teacher['name']  ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" class="btn btn-primary mt-4" name="add_course">Add Subject</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php

include('includes/scripts.php');
include('includes/footer.php');
?>