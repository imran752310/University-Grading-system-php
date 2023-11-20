<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include_once('includes/connection.php');
    if (isset($_SESSION['LOGIN']) && $_SESSION['LOGIN'] === 1) {
        header('location:index.php');
    }
    ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin panel</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <?php
        if (isset($_POST['login_btn'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];


            $query = "SELECT * FROM  admin_tbl where email='$email'";
            $run = mysqli_query($conn, $query);
            $admin_data = mysqli_fetch_array($run);
            if (!$admin_data) {
                echo "<script>alert('username or password in incorrect')</script>";
            } else {
                $admin_id =  $admin_data['admin_id'];
                $super_admin = $admin_data['super_admin'];
                $name = $admin_data['name'];
                $email_db =  $admin_data['email'];
                $password_db =  $admin_data['password'];
                $campus_id = $admin_data['campus_id'];

                if ($email == $email_db && $password == $password_db) {
                    $_SESSION['LOGIN'] = 1;
                    $_SESSION['role'] = $super_admin === "1" ? 'super_admin' : 'admin';
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email_db;
                    $_SESSION['id'] = $admin_id;
                    $_SESSION['campus_id'] = $campus_id;

                    //if role is admin then get campus id and store in session
                    if ($_SESSION['role'] === 'admin') {
                        $_SESSION['campus_id'] = $campus_id;
                    }


                    if ($super_admin === "1") {
                        header('Location: super-admin/index.php');
                    } else {
                        header('Location: admin/index.php');
                    }
                } else {
                    echo "<script>alert('username or password in incorrect')</script>";
                }
            }
        }

        ?>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9 mt-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-12 mt-3">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                                    </div>
                                    <form class="user" method="post" action="admin-login.php">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control "
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control "
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" name="login_btn"
                                            class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <a class="btn btn-success btn-user btn-block" href="index.php"> Back Home</a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>