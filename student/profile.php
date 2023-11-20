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
    $confirm_password = $_POST['confirm_password'];
    $password_updated = $password !== "" && $confirm_password !== "" ? true : false;
    if ($password !== $confirm_password) : ?>
<div class="container">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Passwords didn't match.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php else :
        $password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "";
        if ($password_updated) {
            $update_query = "UPDATE student_tbl SET name = '$name', email = '$email', password = '$password' WHERE std_id =" . $_SESSION['id'];
        } else {
            $update_query = "UPDATE student_tbl SET name = '$name', email = '$email' WHERE std_id =" . $_SESSION['id'];
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
endif;
?>

<!--================ Update Code End============= -->


<!--================ Selection============= -->
<?php
$select_query = "SELECT * FROM student_tbl WHERE std_id = " . $_SESSION['id'];

$student = mysqli_fetch_array(mysqli_query($conn, $select_query));

?>
<!--================ Selection end============= -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-md-12 mx-auto">
            <div class="card shadow mb-4" style="border-radius: 40px;">
                <div class="card-header py-3" style="border-radius: 40px;">
                    <h6 class="m-0 font-weight-bold text-primary">Student Profile</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="profile.php">
                            <label for="name">Name</label>
                            <input value="<?php echo $student['name']; ?>" id="name" name="name" type="text"
                                class="form-control mb-2" required placeholder="Full Name" />
                            <label for="email">Email</label>
                            <input value="<?php echo $student['email']; ?>" id="email" name="email" type="email"
                                class="form-control mb-2" required placeholder="user@mail.com" />
                            <label for="password">Password </label>
                            <small class="form-text text-muted">Keep the password field blank if you don't want to
                                change the password.</small>
                            <input id="password" name="password" type="password" class="form-control mb-2"
                                placeholder="***********" />
                            <label for="confirm_password">Confirm Password</label>
                            <input id="confirm_password" name="confirm_password" type="password"
                                class="form-control mb-2" placeholder="***********" />
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