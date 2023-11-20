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
$current_url = '/teacher/assignments.php?course_id=' . $course_id;
?>



<!--================ Delete Code============= -->
<?php
if (isset($_GET['delete_id'])) :
    $del_id = $_GET['delete_id'];
    $del_query = "DELETE from assigment_tbl where assigment_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Assignment Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete assignment, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_assignment'])) :
    $title = $_POST['title'];
    $date = $_POST['date'];
    $course_id = $_POST['course_id'];
    $description = $_POST['description'];

    $query = "INSERT INTO assigment_tbl(title, description, last_date, course_id) 
   VALUES('$title','$description', '$date', '$course_id')";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Assignment added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add assignment, try again!
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
$course_query = "SELECT * FROM course_tbl WHERE course_id = '$course_id' AND teacher_id = " . $_SESSION['id'];
$course_res = mysqli_query($conn, $course_query);
if (mysqli_num_rows($course_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/teacher'>Back to Home</a>";
    echo "</div>";
    exit();
}
$course_title = mysqli_fetch_array($course_res)['title'];

$select_query = "SELECT * FROM assigment_tbl WHERE course_id = '$course_id'";
$assignment_select_res = mysqli_query($conn, $select_query);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-6 mb-4">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <div class="row">
                        <div class="col flex-grow-0">
                            <a href="index.php" class="text-primary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                        <div class="col flex-grow-1">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $course_title; ?> - Assigments</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($assignment = mysqli_fetch_array($assignment_select_res)) : ?>
                        <div class="col-md-12 col-lg-6 p-2">
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col flex-grow-1">
                                        <h3 class="text-primary"><?php echo $assignment['title']; ?></h3>
                                    </div>
                                    <div class="col flex-grow-0">
                                        <!-- delete -->
                                        <a href="<?php echo $current_url . '&delete_id=' . $assignment['assigment_id']; ?>"
                                            onclick="return confirm('Are you sure to delete this assignment?')"
                                            class="text-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <p>Last Date: <strong
                                        class="text-danger"><?php echo $assignment['last_date']; ?></strong></p>
                                <p><?php echo $assignment['description']; ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow mb-4 " >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Assigment</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="<?php $current_url; ?>">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" autocomplete="off" class="form-control" required
                                placeholder="Assignment title" />
                            <label for="date">Date</label>
                            <input id="date" name="date" type="date" autocomplete="off" class="form-control" required
                                placeholder="Enter your Campus" />
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10"
                                class="form-control"></textarea>
                            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
                    </div>
                    <button class="btn btn-primary mt-4" name="add_assignment">Add</button>
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