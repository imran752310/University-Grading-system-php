<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');


?>


<!---============Selection code ===========--->
<?php
$id = $_SESSION['id'];

$course_query = "SELECT * FROM student_course_tbl WHERE student_id ='$id' ";
$course_res = mysqli_query($conn, $course_query);
if (mysqli_num_rows($course_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}

$course_title = mysqli_fetch_array($course_res)['1'];

$select_query = "SELECT * FROM assigment_tbl WHERE course_id = '$course_title'";
$assignment_select_res = mysqli_query($conn, $select_query);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <div class="row">

                        <div class="col flex-grow-1">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title; ?> - Assigments</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($assignment = mysqli_fetch_array($assignment_select_res)) : ?>
                        <div class="col-md-12 col-lg-4 p-2">
                            <div class="card p-2">
                                <p><b>Subject</b> : <strong class="text-danger h4"><?php
                                                                                        $id = $assignment[1];
                                                                                        $ok = mysqli_query($conn, "SELECT * from course_tbl where course_id='$id'");
                                                                                        $data_course = mysqli_fetch_assoc($ok);
                                                                                        echo   $data_course['title'];
                                                                                        ?></strong>
                                </p>

                                <div class="row">
                                    <div class="col flex-grow-1">
                                        <p class=""> <b>Assigment Title :</b> <?php echo $assignment['title']; ?>
                                        </p>
                                    </div>

                                </div>

                                <p><b>Description :</b> <?php echo $assignment['description']; ?></p>
                                <p>Last Date: <strong
                                        class="text-danger"><?php echo $assignment['last_date']; ?></strong></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
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
