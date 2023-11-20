<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!--================ Update Select Code============= -->
    <?php
    if (isset($_POST['update_event'])) {
        echo  $updat_id = $_POST['update_id'];

        echo  $Title = $_POST['Title'];
        echo $discription = $_POST['discription'];
        echo $Dates = $_POST['Date'];
        echo  $Times = $_POST['Time'];


        $update_q = "UPDATE event_tbl set title='$Title', description='$discription' , date='$Dates',time='$Times' where event_id='$updat_id'";
        $updat_exect = mysqli_query($conn, $update_q);
        if ($updat_exect) {
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Hi!</strong> Events Update Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            header("location:events.php");
        }
    }
    ?>





    <!--================ Insertipion Code============= -->

    <?php
    if (isset($_POST['event_btn'])) {
        $Title = $_POST['Title'];
        $discription = $_POST['discription'];
        $Dates = $_POST['Date'];
        $Times = $_POST['Time'];
        $dept_id = $_POST['dept_id'];


        $query = "INSERT into event_tbl (title,description,date,time,dept_id)VALUES('$Title','$discription','$Dates','$Times','$dept_id')";
        $run = mysqli_query($conn, $query);
        if ($run) {
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Hi!</strong> Events add Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            header("location:events.php");
        }
    }
    ?>
    <!--================ Insertipion Code============= -->
    <!--================ Delete Code============= -->
    <?php
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];

        $del_query = "DELETE from event_tbl where event_id='$del_id'";
        $execute = mysqli_query($conn, $del_query);
        if ($execute) {
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hi!</strong> Event Delete Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            header("location:events.php");
        }
    }
    ?>
    <!--================ Delete Code============= -->


    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">All Events</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S no</th>
                                    <th>Tile</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Update</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!---============Selection code ===========--->
                                <?php
                                $sno = 1;
                                $dept_id = $_SESSION['campus_id'];
                                $select_query = "SELECT * FROM event_tbl where dept_id='$dept_id'";
                                $execte = mysqli_query($conn, $select_query);
                                while ($data = mysqli_fetch_array($execte)) {
                                ?>
                                <tr>
                                    <td><?php echo $sno++ ?></td>
                                    <td><?php echo $data[1] ?></td>
                                    <td><?php echo $data[2] ?></td>
                                    <td><?php echo $data[3] ?></td>
                                    <td><?php echo $data[4] ?></td>
                                    <td>
                                        <a href="events.php?updat_id=<?php echo $data[0] ?>"
                                            class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="events.php?del_id=<?php echo $data[0] ?>"
                                            onclick="return confirm('Are you sure To delete This Events!')"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-4">
            <!-- DataTales Example -->
            <?php

            if (isset($_GET['updat_id'])) :
                $updat_id = $_GET['updat_id'];
                $update_select = "SELECT * from event_tbl where event_id='$updat_id'";
                $execte_select =  mysqli_query($conn, $update_select);
                while ($update_data = mysqli_fetch_array($execte_select)) :
            ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Update Events</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="events.php">

                            <label for="name">Title :</label>
                            <input id="name" type="hidden" name="update_id" value="<?php echo $update_data['0'] ?>" />
                            <input id="name" name="Title" value="<?php echo $update_data['1'] ?>" autocomplete="off"
                                class="form-control" required placeholder="Enter your Events" />
                            <label for="date">Date :</label>
                            <input type="date" id="date" value="<?php echo $update_data['3'] ?>" name="Date"
                                autocomplete="off" class="form-control" required placeholder="Enter your Events" />
                            <label for="time">Time :</label>
                            <input type="time" id="time" name="Time" value="<?php echo $update_data['4'] ?>"
                                autocomplete="off" class="form-control" required placeholder="Enter your Events" />
                            <label for="date">Discription :</label>
                            <textarea name="discription" class="form-control" required placeholder="Enter your Events"
                                id="" cols="30" rows="4"><?php echo $update_data['2'] ?></textarea>
                            <button class="btn btn-primary mt-4" name="update_event">
                                update
                            </button>

                        </form>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <?php else : ?>
            <div class="card shadow mb-4" >
                <div class="card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Add Events</h6>
                </div>
                <div class="card-body">
                    <div class="">
                        <form method="post" action="events.php">

                            <label for="name">Title :</label>
                            <input id="name" type="hidden" name="dept_id"
                                value="<?php echo $dept_id = $_SESSION['campus_id']; ?>" />
                            <input id="name" name="Title" autocomplete="off" class="form-control" required
                                placeholder="Enter your Events" />
                            <label for="date">Date :</label>
                            <input type="date" id="date" name="Date" autocomplete="off" class="form-control" required
                                placeholder="Enter your Events" />
                            <label for="time">Time :</label>
                            <input type="time" id="time" name="Time" autocomplete="off" class="form-control" required
                                placeholder="Enter your Events" />
                            <label for="date">Discription :</label>
                            <textarea name="discription" class="form-control" required placeholder="Enter your Events"
                                id="" cols="30" rows="4"></textarea>
                            <button class="btn btn-primary mt-4" name="event_btn">
                                Submit
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php endif; ?>




    <?php

?>

</div>



<?php

include('includes/scripts.php');
include('includes/footer.php');
?>