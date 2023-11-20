<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>

<!--================ Update Code============= -->

<?php
if (isset($_POST['edit_profile'])) :
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_query = "";
    if ($password_updated) {
        $update_query = "UPDATE teacher_tbl SET name = '$name', email = '$email', password = '$password' WHERE teacher_id =" . $_SESSION['id'];
    } else {
        $update_query = "UPDATE teacher_tbl SET name = '$name', email = '$email' WHERE teacher_id =" . $_SESSION['id'];
    }
    $run = mysqli_query($conn, $update_query);

?>
<div class="container">
    <?php if ($run) :
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
        ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Profile updated successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to update profile, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif;
?>

<!--================ Update Code End============= -->


<!--================ Selection============= -->
<?php
$select_query = "SELECT * FROM teacher_tbl WHERE teacher_id = " . $_SESSION['id'];

$teacher = mysqli_fetch_array(mysqli_query($conn, $select_query));

?>
<!--================ Selection end============= -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-md-12 mx-auto">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Teacher Profile</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="profile.php">
                            <label for="name">Name</label>
                            <input value="<?php echo $teacher['name']; ?>" id="name" name="name" type="text"
                                class="form-control mb-2" required placeholder="Full Name" />
                            <label for="email">Email</label>
                            <input value="<?php echo $teacher['email']; ?>" id="email" name="email" type="email"
                                class="form-control mb-2" required placeholder="user@mail.com" />
                            <label for="password">Password </label>
                            <small class="form-text text-muted">Keep the password field blank if you don't want to
                                change the password.</small>
                            <input id="password" name="password" type="password" class="form-control mb-2"
                                placeholder="***********" />

                            <button class="btn btn-primary mt-4" name="edit_profile" type="submit">Update</button>
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