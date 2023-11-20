<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>



<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_fee_deatil'])) :
    $title = $_POST['title'];
    $description = $_POST['description'];

    $query = "INSERT INTO fee_details_tbl(title, description) VALUES('$title','$description')";
    $run = mysqli_query($conn, $query);

?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Hi!</strong> Fee Details add successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to add Fee Details, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>
</div>
<?php endif;
?>

<!--================ Insertion Code End============= -->


<!--================ Delete Code============= -->
<?php
if (isset($_GET['del_id'])) :
    $del_id = $_GET['del_id'];
    $del_query = "DELETE FROM fee_details_tbl WHERE fee_details_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Fee Details Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete Fee Details, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php

        endif; ?>
<?php endif; ?>
<!--================ Delete Code end============= -->


<!--================ Edit Code ============= -->

<!-- ADD Code here -->
<?php
if (isset($_POST['update_fee_details'])) :
    $update_id = $_POST['update_id'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description'];


    $update_q = "UPDATE fee_details_tbl SET title='$update_title',description='$update_description' where fee_details_id='$update_id'";
    $run = mysqli_query($conn, $update_q);

?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Fee Deatil Update successfully!
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
?>

<!--================ Edit Code end============= -->

<!--================ Selection============= -->
<?php
$sno = 1;
$select_query = "SELECT * from  fee_details_tbl";

$run = mysqli_query($conn, $select_query);

?>
<!--================ Selection end============= -->

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Student Fee Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="campusesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Discription</th>
                                    <th>Edite</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($fee_details = mysqli_fetch_assoc($run)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $fee_details['title'] ?></td>
                                    <td><?php echo $fee_details['description'] ?></td>

                                    <td>
                                        <!-- Edit -->
                                        <a href="student-fee.php?edit_id=<?php echo $fee_details['fee_details_id']; ?>"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <!-- Delete -->
                                        <a href="student-fee.php?del_id=<?php echo $fee_details['fee_details_id']; ?>"
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
                $fetch_updat_data = mysqli_query($conn, "SELECT * FROM fee_details_tbl where fee_details_id='$id'");
                while ($data = mysqli_fetch_array($fetch_updat_data)) :
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Admin</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="student-fee.php">
                            <input id="name" name="update_id" value="<?php echo $data[0] ?>" type="hidden" />
                            <label for="name">Title</label>
                            <input id="name" name="update_title" value="<?php echo $data[1] ?>" type="text"
                                class="form-control mb-2" required placeholder="Full Name" />
                            <label for="email">Description</label>

                            <textarea name="update_description" class="form-control mb-2" id="" cols="30"
                                rows="5"><?php echo $data[2] ?></textarea>
                            <button class="btn btn-primary mt-4" name="update_fee_details" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else :

                ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Fee Deatils</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="student-fee.php">
                            <label for="name">Tite</label>
                            <input id="name" name="title" type="text" class="form-control mb-2" required
                                placeholder="Enter Title" />
                            <label for="email">Description</label>
                            <textarea name="description" placeholder="Enter Description" class="form-control mb-2" id=""
                                cols="30" rows="5"></textarea>

                            <button class="btn btn-primary mt-4" name="add_fee_deatil" type="submit">Add</button>
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