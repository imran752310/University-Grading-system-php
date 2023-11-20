<?php
include("includes/header.php");
include("includes/top_bar.php");
include("includes/navbar.php");


if (isset($_SESSION['LOGIN']) && $_SESSION['LOGIN'] === 1) {
    header('location:index.php');
}

if (isset($_POST['Student_login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = "SELECT * FROM  student_tbl where email='$email'";
    $run = mysqli_query($conn, $query);
    $student_data = mysqli_fetch_array($run);
    if (!$student_data) {
        echo "<script>alert('username or password in incorrect')</script>";
    } else {
        $student_id =  $student_data['std_id'];
        $name = $student_data['name'];
        $email_db =  $student_data['email'];
        $password_db =  $student_data['password'];
        $campus_id = $student_data['campus_id'];
        $batch_id = $student_data['batch_id'];

        if ($email == $email_db && $password == $password_db) {
            $_SESSION['LOGIN'] = 1;
            $_SESSION['role'] = 'student';
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email_db;
            $_SESSION['id'] = $student_id;
            $_SESSION['campus_id'] = $campus_id;
            $_SESSION['batch_id'] = $batch_id;
            header('Location: student/index.php');
        } else {
            echo "<script>alert('username or password in incorrect')</script>";
        }
    }
}

?>
<!-- slider-start -->
<div class="slider-area">
    <div class="page-title">
        <div class="single-slider slider-height slider-height-breadcrumb d-flex align-items-center"
            style="background-image: url(assets/img/bg/others_bg.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-6 col-md-10 offset-md-1 ml-md-auto">
                        <div class="events-details-form faq-area-form mb-30 p-0">
                            <form action="student-login.php" method='POST'>
                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="events-form-title mb-25 ">
                                            <h2 style="color:white"> Student Login</h2>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <input placeholder="Enter UserName" name='email' type="email">

                                        <input placeholder="Password :" name="password" type="password">

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="faq-form-btn events-form-btn">
                                            <button class="btn m-0" name="Student_login" type="submit"> Login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider-end -->
<!-- courses start -->
<div class="advisors-area gray-bg pt-95 pb-70">
    <div class="container">
        <div class="row">


        </div>
    </div>
</div>
<!-- courses end -->



<?php
include("includes/footer.php");
include("includes/script.php");

?>