<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>


<!--================ Insertion Code============= -->

<?php
if (isset($_POST['add_campus'])) :
    $campus = $_POST['campus'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $query = "INSERT INTO campus_tbl(campus_name, address, contact) VALUES('$campus','$address', '$contact')";
    $run = mysqli_query($conn, $query); ?>
<div class="container">
    <?php if ($run) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Wow!</strong> Campus add Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Opps!</strong> Failed to add campus
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
    $del_query = "DELETE from campus_tbl where campus_id ='$del_id'";
    $execute = mysqli_query($conn, $del_query);
?>
<div class="container">
    <?php if ($execute) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Campus Deleted Successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php else : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Unable to delete campus, try again!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<?php endif; ?>


<?php endif; ?>
<!--================ Delete Code end============= -->

<!---------------update code--------------------->
<?php
if (isset($_POST['Update_campus'])) :
    $id = $_POST['campus_id'];
    $campus_name = $_POST['updt_campus'];
    $campus_address = $_POST['updt_address'];
    $campus_contact = $_POST['updt_contact'];

    $exect = mysqli_query($conn, "UPDATE campus_tbl SET campus_name='$campus_name',address='$campus_address',contact='$campus_contact' where campus_id='$id'");
?>

<?php if ($exect) : ?>
<div class="alert alert-success alert-dismissible fade show col-10 m-5" role="alert">
    Campus Update Successfully!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php else : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Unable to Update campus, try again!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>
<?php endif; ?>


<!---------------update code--------------------->

<!--================ Selection============= -->
<?php
$sno = 1;
$select_query = "SELECT * FROM campus_tbl";
$campuses = mysqli_query($conn, $select_query);
?>
<!--================ Selection end============= -->
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">All Campuses</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="campusesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Campus</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($campus = mysqli_fetch_assoc($campuses)) : ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $campus['campus_name'] ?></td>
                                    <td><?php echo $campus['address'] ?></td>
                                    <td><?php echo $campus['contact'] ?></td>
                                    <td>
                                        <!-- Edit -->
                                        <a href="campus.php?edit_id=<?php echo $campus['campus_id']; ?>"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <!-- Delete -->
                                        <a href="campus.php?del_id=<?php echo $campus['campus_id']; ?>"
                                            onclick="return confirm('Are you sure to delete this campus?')"
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

            <!--================ Edit Code ============= -->

            <?php
            if (isset($_GET['edit_id'])) {
                $id = $_GET['edit_id'];
                $run = mysqli_query($conn, "SELECT * from campus_tbl where campus_id='$id'");
                while ($campus = mysqli_fetch_array($run)) {
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Campus</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="campus.php">
                            <input type="hidden" id="cmapus" name="campus_id"
                                value="<?php echo $id =  $campus['0']; ?>">
                            <label for="cmapus">Campus Name</label>
                            <input id="cmapus" name="updt_campus" value="<?php echo $id =  $campus['1']; ?>"
                                class="form-control" required />
                            <label for="address">Address</label>
                            <input id="address" name="updt_address" value="<?php echo $id =  $campus['2']; ?>"
                                class="form-control" required placeholder="Enter Campus address" />
                            <label for="contact">Contact</label>
                            <input id="contact" name="updt_contact" value="<?php echo $id =  $campus['3']; ?>"
                                class="form-control" required placeholder="Enter Campus contact" />
                            <button class="btn btn-primary mt-4" name="Update_campus" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
                }
            } else {
                ?>
            <!--================ Edit Code end============= -->
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Campus</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="campus.php">
                            <label for="cmapus">Campus Name</label>
                            <input id="cmapus" name="campus" class="form-control" required
                                placeholder="Enter Campus name" />
                            <label for="address">Address</label>
                            <input id="address" name="address" class="form-control" required
                                placeholder="Enter Campus address" />
                            <label for="contact">Contact</label>
                            <input id="contact" name="contact" class="form-control" required
                                placeholder="Enter Campus contact" />
                            <button class="btn btn-primary mt-4" name="add_campus" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }


            ?>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>