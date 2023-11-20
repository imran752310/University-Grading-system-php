<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>



<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_admin'])) :
    $name = $_POST['name'];
    $email = $_POST['email'];
    $campus = $_POST['campus'];
    $password = $_POST['password'];

    if ($campus === 'Select Campus') : ?>
<div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please select a campus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<?php else :


        $query = "INSERT INTO admin_tbl(name, email, password, campus_id) VALUES('$name','$email', '$password', $campus)";
        $run = mysqli_query($conn, $query);

    ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Admin add successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add admin, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif;
endif;
?>

<!--================ Insertion Code End============= -->


<!--================ Delete Code============= -->
<?php
if (isset($_GET['del_id'])) :
    $del_id = $_GET['del_id'];
    $del_query = "DELETE FROM admin_tbl WHERE admin_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Admin Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete admin, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<!--================ Delete Code end============= -->


<!--================ Edit Code ============= -->

<!-- ADD Code here -->
<?php
if (isset($_POST['update_admin'])) :
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];
    $update_campus = $_POST['update_campus'];
    $update_password = $_POST['update_password'];

    if ($update_campus === 'Select Campus') : ?>
<div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Please select a campus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<?php else :

        $update_q = "UPDATE admin_tbl SET name='$update_name',email='$update_email',password='$update_password',campus_id='$update_campus' where admin_id='$update_id'";
        $run = mysqli_query($conn, $update_q);

    ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Admin Update successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to Update admin, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif;
endif;
?>

<!--================ Edit Code end============= -->

<!--================ Selection============= -->
<?php
$sno = 1;
$select_query =
    "SELECT admin_tbl.admin_id, admin_tbl.name, admin_tbl.email, campus_tbl.campus_name 
    FROM campus_tbl
    INNER JOIN admin_tbl ON campus_tbl.campus_id = admin_tbl.campus_id
    ";
$admins = mysqli_query($conn, $select_query);


// Getting un assigned campused list
$unassigned_campuses_query =
    "SELECT c.campus_id, c.campus_name
        FROM campus_tbl c
        LEFT JOIN admin_tbl a ON c.campus_id = a.campus_id
        WHERE a.campus_id IS NULL";

$remaining_campuses_result = mysqli_query($conn, $unassigned_campuses_query);

?>
<!--================ Selection end============= -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">All Admins</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="campusesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Campus</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($admin = mysqli_fetch_assoc($admins)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $admin['name'] ?></td>
                                    <td><?php echo $admin['email'] ?></td>
                                    <td><?php echo $admin['campus_name'] ?></td>
                                    <td>
                                        <!-- Edit -->
                                        <a href="admins.php?edit_id=<?php echo $admin['admin_id']; ?>"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <!-- Delete -->
                                        <a href="admins.php?del_id=<?php echo $admin['admin_id']; ?>"
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
            <?php
            if (isset($_GET['edit_id'])) :
                $id = $_GET['edit_id'];
                $fetch_updat_data = mysqli_query($conn, "SELECT * FROM admin_tbl where admin_id='$id'");
                while ($data = mysqli_fetch_array($fetch_updat_data)) :
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Admin</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="admins.php">
                            <input id="name" name="update_id" value="<?php echo $data[0] ?>" type="hidden" />
                            <label for="name">Name</label>
                            <input id="name" name="update_name" value="<?php echo $data[1] ?>" type="text"
                                class="form-control mb-2" required placeholder="Full Name" />
                            <label for="email">Email</label>
                            <input id="email" name="update_email" value="<?php echo $data[2] ?>" type="email"
                                class="form-control mb-2" required placeholder="user@mail.com" />
                            <label for="campus">Campus</label>
                            <select name="update_campus" id="campus" class="custom-select mb-2">
                                <option value="<?php echo $data[4]; ?>" selected><?php $id = $data[4];
                                                                                            $run = mysqli_query($conn, "SELECT * from campus_tbl where campus_id='$id'");
                                                                                            $campus_data = mysqli_fetch_array($run);
                                                                                            echo $campus_data['1'];
                                                                                            ?></option>
                                <?php
                                        if ($remaining_campuses_result) {
                                            while ($campus = mysqli_fetch_assoc($remaining_campuses_result)) {
                                                echo "<option value ='" . $campus['campus_id'] . "'>" . $campus['campus_name'] . "</option>";
                                            }
                                        }
                                        ?>
                            </select>
                            <label for="password">Password</label>
                            <input id="password" name="update_password" type="password" class="form-control"
                                placeholder="***********" />


                            <button class="btn btn-primary mt-4" name="update_admin" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else :

                ?>

            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Admin</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="admins.php">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" class="form-control mb-2" required
                                placeholder="Full Name" />
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control mb-2" required
                                placeholder="user@mail.com" />
                            <label for="campus">Campus</label>
                            <select name="campus" id="campus" class="custom-select mb-2">
                                <option value="Select Campus" selected>Select Campus</option>
                                <?php
                                    if ($remaining_campuses_result) {
                                        while ($campus = mysqli_fetch_assoc($remaining_campuses_result)) {
                                            echo "<option value ='" . $campus['campus_id'] . "'>" . $campus['campus_name'] . "</option>";
                                        }
                                    }
                                    ?>
                            </select>
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" class="form-control mb-2" required
                                placeholder="***********" />


                            <button class="btn btn-primary mt-4" name="add_admin" type="submit">Add</button>
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