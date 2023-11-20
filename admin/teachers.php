<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
$campus_id = $_SESSION['campus_id'];
?>

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_teacher'])) :
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['contact'];
    $dept = $_POST['dept'];
    $password = $_POST['password'];

    if ($dept == 'select_department') : ?>
<div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please select department.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php else :

        $query = "INSERT INTO teacher_tbl(name, email, contact, password, campus_id, dept_id ) 
        VALUES('$name','$email','$phone','$password', '$campus_id','$dept')";
        $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Teacher added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add teacher, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<!--================ Insertion Code End============= -->


<!--================ Delete Code============= -->
<?php
if (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];
    $del_query = "DELETE from teacher_tbl where teacher_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Teacher deleted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete teacher, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif;
    }
?>
<!--================ Delete Code============= -->



<!--================ Edit Code ============= -->
<?php
if (isset($_POST['update_teacher'])) :
    $update_id = $_POST["update_id"];
    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];
    $update_phone = $_POST['update_contact'];
    $update_dept = $_POST['update_dept'];
    $update_password = $_POST['update_password'];

    $query = "UPDATE teacher_tbl SET name='$update_name', email='$update_email',contact='$update_phone', password='$update_password',  dept_id='$update_dept' where teacher_id ='$update_id'";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Teacher Update successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to Update Teacher, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!--================ Edit Code end============= -->



<!--================ Selectoin Code============= -->
<?php
$sno = 1;

$dept_select_query = "SELECT *  FROM dept_tbl where campus_id='$campus_id'";
$dept_res = mysqli_query($conn, $dept_select_query);

// teachers select query with inner join get dept title from dept_tbl through dept_id
$select_query = "SELECT * FROM teacher_tbl INNER JOIN dept_tbl ON teacher_tbl.dept_id = dept_tbl.dept_id";
$result = mysqli_query($conn, $select_query);


?>
<!--================ Selectoin Code end============= -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
    if (isset($_GET['teacher_edit_id'])) :
        $id =   $_GET['teacher_edit_id'];
        $run = mysqli_query($conn, "SELECT * FROM teacher_tbl where teacher_id='$id'");
    ?>
    <div class="card shadow mb-4" >
        <div class="card-header py-3" >
            <h6 class="m-0 font-weight-bold text-primary">Update Teacher</h6>
        </div>
        <div class="card-body p-5">
            <form method="POST" action="teachers.php">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <?php
                            while ($teacher_data = mysqli_fetch_array($run)) {
                            ?>
                        <label for="name">Teacher Name</label>
                        <input type="hidden" id="name" name="update_id" value="<?php echo $teacher_data['0']; ?>">
                        <input type="text" id="name" name="update_name" value="<?php echo $teacher_data['1']; ?>"
                            autocomplete="off" class="form-control" required placeholder="Enter teacher name" />
                        <label for="email"> Email</label>
                        <input type="email" id="email" name="update_email" value="<?php echo $teacher_data['2']; ?>"
                            autocomplete="off" class="form-control" required placeholder="teacher@mail.com" />

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="contact">Contact</label>
                        <input type="text" id="contact" name="update_contact" value="<?php echo $teacher_data['3']; ?>"
                            autocomplete="off" class="form-control" required placeholder="03** **** ***" />
                        <label for="dept"> Department</label>
                        <select id="dept" class="form-control" name="update_dept">
                            <option value="<?php echo $teacher_data['6']; ?>"><?php
                                                                                    $id = $teacher_data['6'];
                                                                                    $ext = mysqli_query($conn, "SELECT* FROM dept_tbl where dept_id='$id'");
                                                                                    $dept = mysqli_fetch_array($ext);
                                                                                    echo    $dept['1'];
                                                                                    ?></option>
                            <?php while ($dept = mysqli_fetch_array($dept_res)) : ?>
                            <option value="<?php echo $dept['dept_id'] ?>"><?php echo $dept['title'] ?></option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="password">Password</label>
                        <small class="form-text text-muted">Keep it field blank if you don't want to change
                            the password.</small>
                        <input type="password" id="password" name="update_password" class="form-control mb-2"
                            placeholder="*********" />
                        <button class="ml-3 btn btn-primary mt-4" name="update_teacher">Update</button>
                    </div>

                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <?php
    else :
    ?>
    <div class="card shadow mb-4" >
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Teacher</h6>
        </div>
        <div class="card-body p-5">
            <form method="POST" action="teachers.php">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="name">Teacher Name</label>
                        <input type="text" id="name" name="name" autocomplete="off" class="form-control" required
                            placeholder="Enter teacher name" />
                        <label for="email"> Email</label>
                        <input type="email" id="email" name="email" autocomplete="off" class="form-control" required
                            placeholder="teacher@mail.com" />

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="contact">Contact</label>
                        <input type="text" id="contact" name="contact" autocomplete="off" class="form-control" required
                            placeholder="03** **** ***" />
                        <label for="dept"> Department</label>
                        <select id="dept" class="form-control" name="dept">
                            <option value="select_department">Select Department</option>
                            <?php while ($dept = mysqli_fetch_array($dept_res)) : ?>
                            <option value="<?php echo $dept['dept_id'] ?>"><?php echo $dept['title'] ?></option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control mb-2"
                            placeholder="*********" />
                        <button class="ml-3 btn btn-primary mt-4" name="add_teacher">Add</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <div class="card shadow mb-4" >
        <div class="card-header py-3" >
            <h6 class="m-0 font-weight-bold text-primary">All Teachers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($teacher = mysqli_fetch_array($result)) :
                        ?>
                        <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $teacher['name'] ?></td>
                            <td><?php echo $teacher['title'] ?></td>
                            <td><?php echo $teacher['contact'] ?></td>
                            <td><?php echo $teacher['email'] ?></td>
                            <td>
                                <!-- Edit -->
                                <a href="teachers.php?teacher_edit_id=<?php echo $teacher['teacher_id'] ?>"
                                    class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            </td>

                            <td>
                                <!-- Delete -->
                                <a href="teachers.php?del_id=<?php echo $teacher['teacher_id'] ?>"
                                    onclick="return confirm('Are you sure you want to delete this teacher?')"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>