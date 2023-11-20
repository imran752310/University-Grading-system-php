<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>


<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_dept'])) :
    $title = $_POST['title'];
    $campus = $_SESSION['campus_id'];

    $query = "INSERT INTO dept_tbl(title, campus_id) VALUES('$title','$campus')";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Department add Successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add department, Try again!
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
if (isset($_GET['del_id'])) :
    $del_id = $_GET['del_id'];
    $del_query = "DELETE from dept_tbl where dept_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Department Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete department, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->



<!--================ Edit Code ================== -->
<?php
if (isset($_POST['edit_dept'])) :
    $title = $_POST['title'];
    $id = $_POST['id'];

    $update_query = "UPDATE dept_tbl SET title = '$title' WHERE dept_id = '$id'";
    $run = mysqli_query($conn, $update_query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Department updated Successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to update department, Try again!
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

$select_query = "SELECT * FROM dept_tbl WHERE campus_id = " . $_SESSION['campus_id'];
$depts = mysqli_query($conn, $select_query);
?>
<!--================ Selection end============= -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">All Departments</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php while ($dept = mysqli_fetch_assoc($depts)) : ?>
                        <div class="col-6 col-md-4 mb-2">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="text-lg"><?php echo $dept['title'] ?></h6>
                                        <a href="department.php?id=<?php echo $dept['dept_id'] ?>"
                                            class="btn btn-circle btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a data-toggle="modal" data-edit-id="<?php echo $dept['dept_id'] ?>"
                                            data-dept-title="<?php echo $dept['title'] ?>" data-target="#dept-edit"
                                            href="#" class="btn btn-circle btn-outline-success">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="departments.php?del_id=<?php echo $dept['dept_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this department?')"
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
            <div class="card shadow mb-4" >
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Department</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="departments.php">
                            <label for="title">Title</label>
                            <input id="title" name="title" class="form-control" required
                                placeholder="Enter department name" />
                            <button class="btn btn-primary mt-4" name="add_dept" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->


<!-- Modal -->
<div class="modal fade" id="dept-edit" tabindex="-1" aria-labelledby="dept-editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dept-editLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form method="POST" action="departments.php">
                        <label for="title">Title</label>
                        <input id="title" name="title" class="form-control" required
                            placeholder="Enter department name" />
                        <input type="hidden" id="id" name="id" class="form-control" required placeholder="Id" />
                        <button type="submit" name="edit_dept" class="btn btn-primary mt-2">Save changes</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
<script>
$("#dept-edit").on("show.bs.modal", function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var editId = button.data("edit-id"); // Extract the edit-id value from the button
    var editTitle = button.data("dept-title");
    var modal = $(this);
    modal.find("#id").val(editId); // Set the value of the hidden input field in the modal form
    modal.find("#title").val(editTitle);
});
</script>