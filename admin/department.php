<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$dept_id = $_GET['id'];
?>

<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_batch'])) :
    $name = $_POST['name'];
    $dept = $_POST['dept_id'];

    $query = "INSERT INTO batch_tbl(batch_name, dept_id) VALUES('$name','$dept')";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Batch added successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add batch, try again!
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
if (isset($_GET['del_batch_id'])) :
    $del_id = $_GET['del_batch_id'];
    $del_query = "DELETE from batch_tbl where batch_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Batch Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete batch, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->




<!--================ Selection============= -->
<?php
$select_dept_title = "SELECT title FROM dept_tbl WHERE dept_id =" . $_GET['id'];
$select_query = "SELECT * FROM batch_tbl WHERE dept_id = " . $_GET['id'];
$dept_title_res = mysqli_query($conn, $select_dept_title);
if (mysqli_num_rows($dept_title_res) == 0) {
    echo "<div class='text-center'>";
    echo "<h2 class='text-center text-danger'>Invalid ID</h2>";
    echo "<a class='btn btn-primary' href='/admin'>Back to Home</a>";
    echo "</div>";
    exit();
}
$title = mysqli_fetch_array($dept_title_res)['title'];
$batches = mysqli_query($conn, $select_query);
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
                            <a href="/admin/departments.php" class="btn text-primary btn-sm">
                                <i class="fas fa-arrow-left"></i>
                                <span class="sr-only">Back</span>
                            </a>
                        </div>
                        <h6 class="m-0 font-weight-bold text-primary flex-grow-1"><?php echo $title ?> Batches</h6>

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($batch = mysqli_fetch_assoc($batches)) : ?>
                        <div class="col-6 col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-lg"><?php echo $batch['batch_name'] ?></h6>
                                        <a href="students.php?dept_id=<?php echo $dept_id ?>&batch_id=<?php echo $batch['batch_id'] ?>"
                                            class="btn btn-circle btn-outline-primary">
                                            <i class="fas fa-graduation-cap"></i>
                                        </a>
                                        <a href="courses.php?dept_id=<?php echo $dept_id ?>&batch_id=<?php echo $batch['batch_id'] ?>"
                                            class="btn btn-circle btn-outline-primary">
                                            <i class="fas fa-book"></i>
                                        </a>

                                        <a href="department.php?id=<?php echo $dept_id ?>&del_batch_id=<?php echo $batch['batch_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this batch?')"
                                            class="btn btn-circle btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">

            <?php
            if (isset($_GET['dept_id'])) :
                $id = $_GET['dept_id'];
                $exect = mysqli_query($conn, "SELECT * FROM batch_tbl where batch_id=$id");
                while ($batch_data = mysqli_fetch_array($exect)) :

                endwhile;
            endif;
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Batch</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="department.php?id=<?php echo $_GET['id'] ?>"
                            enctype="multipart/form-data">
                            <label for="name">Batch Name</label>
                            <input id="name" name="name" class="form-control" required placeholder="Enter batch name" />
                            <input type="hidden" name="dept_id" class="form-control" required
                                placeholder="Enter dept id" value="<?php echo $_GET['id'] ?>" />
                            <button class="btn btn-primary mt-4" name="add_batch" type="submit">Add</button>
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