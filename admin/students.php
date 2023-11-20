<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');

$campus_id = $_SESSION['campus_id'];

if (!isset($_GET['dept_id']) || !isset($_GET['batch_id']) || !is_numeric($_GET['dept_id']) || !is_numeric($_GET['batch_id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$dept_id = $_GET['dept_id'];
$batch_id = $_GET['batch_id'];

$current_page = 'students.php?dept_id=' . $dept_id . '&batch_id=' . $batch_id;
?>

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_student'])) :
    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $email = $_POST['email'];
    $phone = $_POST['contact'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $query = "INSERT INTO student_tbl(name, email, password, contact, address, campus_id, batch_id, semester ) 
    VALUES('$name','$email','$password','$phone', '$address', '$campus_id','$batch_id','$semester ')";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Student added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add student, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!--================ Insertion Code End============= -->


<!--================ Delete Code============= -->
<?php
if (isset($_GET['std_delete_id'])) :
    $del_id = $_GET['std_delete_id'];
    $del_query = "DELETE from student_tbl where std_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Student deleted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete student, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->

<!--================ Edit Code ============= -->
<?php
if (isset($_POST['Update_student'])) :
    $std_id = $_POST["std_id"];
    $batch_id = $_POST['update_batch_id'];
    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];
    $update_phone = $_POST['update_contact'];
    $update_address = $_POST['update_address'];
    $update_password = $_POST['update_password'];

    $query = "UPDATE student_tbl SET name='$update_name', email='$update_email', password='$update_password', contact='$update_phone', address='$update_address', batch_id='$batch_id' where std_id ='$std_id'";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Student Update successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to Update student, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!--================ Edit Code end============= -->


<!--================ Selection============= -->
<?php
$sno = 1;
$select_dept_title = "SELECT title FROM dept_tbl WHERE dept_id = '$dept_id'";
$select_batch_title = "SELECT batch_name FROM batch_tbl WHERE batch_id = '$batch_id'";
$select_query = "SELECT * FROM student_tbl WHERE batch_id = '$batch_id' ";

$dept_title_res = mysqli_query($conn, $select_dept_title);
$batch_title_res = mysqli_query($conn, $select_batch_title);
if (mysqli_num_rows($dept_title_res) == 0 || mysqli_num_rows($batch_title_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$dept_title = mysqli_fetch_array($dept_title_res)['title'];
$batch_title = mysqli_fetch_array($batch_title_res)['batch_name'];

$students = mysqli_query($conn, $select_query);
?>
<!--================ Selection end============= -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <div class="d-flex px-2 align-items-center">
                        <div class="flex-grow-0">
                            <a href="department.php?id=<?php echo $dept_id ?>" class="btn text-primary btn-sm">
                                <i class="fas fa-arrow-left"></i>
                                <span class="sr-only">Back</span>
                            </a>
                        </div>
                        <h6 class="m-0 font-weight-bold text-primary flex-grow-1">
                            <?php echo $dept_title . ' - ' . $batch_title ?></h6>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="studentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Semester</th>
                                    <th>Email</th>
                                    <th>Address & Contact</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($student = mysqli_fetch_assoc($students)) : ?>
                                <tr>
                                    <td>
                                        <a
                                            href="student.php?std_id=<?php echo $student['std_id'] . '&dept_id=' . $dept_id . '&batch_id=' . $batch_id;  ?>">
                                            <?php echo $sno++ ?>
                                        </a>
                                    </td>

                                    <td>
                                        <a
                                            href="student.php?std_id=<?php echo $student['std_id'] . '&dept_id=' . $dept_id . '&batch_id=' . $batch_id;  ?>">
                                            <?php echo $student['name'] ?>
                                        </a>
                                    </td>
                                    <td><?php echo $student['semester'] ?></td>
                                    <td><?php echo $student['email'] ?></td>
                                    <td><?php echo $student['address'] . ', ' . $student['contact'] ?></td>
                                    <td>
                                        <!-- Edit -->
                                        <a href="<?php echo $current_page . '&std_edit_id=' . $student['std_id']; ?>"
                                            class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>

                                    <td>
                                        <!-- Delete -->
                                        <a href="<?php echo $current_page . '&std_delete_id=' . $student['std_id']; ?>"
                                            onclick="return confirm('Are you sure to delete this admin?')"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">

            <!---Get id from URL for fetch data --->

            <?php
            if (isset($_GET['std_edit_id'])) :
                $std_id =  $_GET['std_edit_id'];
                $dept_id = $_GET['dept_id'];
                $batch_id = $_GET['batch_id'];
                $q = mysqli_query($conn, "SELECT * From student_tbl where std_id='$std_id'and batch_id='$batch_id'");
                $row = mysqli_fetch_array($q);
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Student</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="<?php echo $current_page ?>">
                            <label for="address">Semester</label>
                            <select id="teacher" name="update_semester" class="form-control">
                                <option value="<?php echo $row['semester'] ?>">
                                    <?php echo $row['semester'] ?></option>
                                <option value="semester 1">ist semester</option>
                                <option value="semester 2">2nd semester</option>
                                <option value="semester 3">3rd semester</option>
                                <option v alue="semester 4">4th semester</option>
                                <option value="semester 5">5th semester</option>
                                <option value="semester 6">6th semester</option>
                                <option value="semester 7">7th semester</option>
                                <option value="semester 8">8th semester</option>
                            </select>
                            <input type="hidden" id="name" name="update_batch_id" value="<?php echo $row[7]; ?>" />
                            <input type="hidden" id="name" name="std_id" value="<?php echo $row[0]; ?>" />
                            <label for="name">Name</label>
                            <input type="text" id="name" name="update_name" value="<?php echo $row[1]; ?>"
                                class="form-control mb-2" required placeholder="Enter student name" />
                            <label for="email">Email</label>
                            <input type="email" id="email" name="update_email" value="<?php echo $row[2]; ?>"
                                class="form-control mb-2" required placeholder="student@mail.com" />
                            <label for="address">Address</label>
                            <input type="text" id="address" name="update_address" value="<?php echo $row[4]; ?>"
                                class="form-control mb-2" required placeholder="Student address" />
                            <label for="contact">Contact</label>
                            <input type="text" id="contact" name="update_contact" value="<?php echo $row[5]; ?>"
                                class="form-control mb-2" required placeholder="03** **** ***" />
                            <label for="password">Password</label>
                            <small class="form-text text-muted">Keep the password field blank if you don't want to
                                change the password.</small>
                            <input type="password" id="password" name="update_password" class="form-control mb-2"
                                placeholder="*********" />

                            <button class="btn btn-primary mt-4" name="Update_student" type="submit">Update</button>
                        </form>
                    </div>
                </div>
                <?php
            else :
                ?>
                <div class="card shadow mb-4" >
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Student</h6>
                    </div>
                    <div class="card-body">
                        <div>
                            <form method="POST" action="<?php echo $current_page ?>" enctype="multipart/form-data">

                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control mb-2" required
                                    placeholder="Enter student name" />
                                <label for="address">Semester</label>
                                <select id="teacher" name="semester" class="form-control">
                                    <option> ...Select semester... </option>
                                    <option value="semester 1">ist semester</option>
                                    <option value="semester 2">2nd semester</option>
                                    <option value="semester 3">3rd semester</option>
                                    <option value="semester 4">4th semester</option>
                                    <option value="semester 5">5th semester</option>
                                    <option value="semester 6">6th semester</option>
                                    <option value="semester 7">7th semester</option>
                                    <option value="semester 8">8th semester</option>
                                </select>
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control mb-2" required
                                    placeholder="student@mail.com" />
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control mb-2" required
                                    placeholder="Student address" />
                                <label for="contact">Contact</label>
                                <input type="text" id="contact" name="contact" class="form-control mb-2" required
                                    placeholder="03** **** ***" />
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control mb-2" required
                                    placeholder="*********" />

                                <button class="btn btn-primary mt-4" name="add_student" type="submit">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif;  ?>
            </div>
        </div>
    </div>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>