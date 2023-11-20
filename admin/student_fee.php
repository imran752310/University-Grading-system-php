<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');




$campus_id = $_SESSION['campus_id'];

?>
<div class="container-fluid">
    <div class="row">

        <div class="col-xl-8 col-md-12">

            <!--================ Insertion Code============= -->

            <?php
            if (isset($_POST['student_fee'])) :
                $std_id = $_POST['std_id'];
                $semester = $_POST['semester'];
                $fee = $_POST['fee'];
                $Date = date('y-m-d');


                $query = "INSERT INTO student_fee_tbl(std_id, semester, amount,date ) 
VALUES('$std_id','$semester','$fee','$Date')";
                $run = mysqli_query($conn, $query); ?>
            <div class="container">
                <?php if ($run) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Student Fee added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php else : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Failed to add student, try again!
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
                $url = 'student_fee.php?std_id=' . $std_id;
                $del_id = $_GET['del_id'];
                $del_query = "DELETE from student_fee_tbl where fee_id ='$del_id'";
                $execute = mysqli_query($conn, $del_query);
            ?>
            <div class="container">
                <?php if ($execute) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Student deleted successfully!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
                        header("location:$url");
                    else : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Unable to delete student, try again!
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
        $sno = 1;
        $select_query = "SELECT * FROM student_tbl WHERE campus_id = '$campus_id' ";
        $students = mysqli_query($conn, $select_query);
        ?>
            <!--================ Selection end============= -->
            <!-- Begin Page Content -->

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex px-2 align-items-center">

                        <h6 class="m-0 font-weight-bold text-primary flex-grow-1">
                            All Student Fee
                        </h6>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="studentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address & Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($student = mysqli_fetch_assoc($students)) : ?>
                                <tr>
                                    <td>
                                        <?php echo $sno++ ?>
                                    </td>
                                    <td>
                                        <?php echo $student['name'] ?>
                                    </td>
                                    <td><?php echo $student['email'] ?></td>
                                    <td><?php echo $student['address'] . ', ' . $student['contact'] ?></td>
                                    <td>
                                        <!-- Edit -->
                                        <a href="student_fee.php?std_id=<?php echo $student['std_id']; ?>"
                                            class="btn btn-success btn-sm">Show Fee</a>
                                        <!-- Delete -->

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

            <!---Get id from URL for fetch data --->

            <?php
            if (isset($_GET['std_id'])) :
                $std_id =  $_GET['std_id'];

                $url = 'student_fee.php?std_id=' . $std_id;
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Submit Student Fee</h6>
                </div>
                <div class="card-body">
                    <div>
                        <form method="POST" action="<?php echo $url ?>">
                            <input type="hidden" id="name" name="std_id" value="<?php echo $std_id; ?>" />
                            <label for="address">Semester</label>
                            <select id="teacher" name="semester" class="form-control">
                                <option>....Select semester....</option>
                                <option value="semester 1">ist semester</option>
                                <option value="semester 2">2nd semester</option>
                                <option value="semester 3">3rd semester</option>
                                <option value="semester 4">4th semester</option>
                                <option value="semester 5">5th semester</option>
                                <option value="semester 6">6th semester</option>
                                <option value="semester 7">7th semester</option>
                                <option value="semester 8">8th semester</option>
                            </select>


                            <label for="address">Fee</label>
                            <input type="text" id="address" name="fee" class="form-control mb-2" required
                                placeholder="Enter Semester Fee" />


                            <button class="btn btn-primary mt-4" name="student_fee" type="submit">Submit</button>
                        </form>
                    </div>
                </div>


            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Student Fee</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="studentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Semester</th>
                                    <th>Fee</th>

                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $sno = 1;
                                    if (isset($_GET['std_id'])) {
                                        $std_id =  $_GET['std_id'];
                                        $student_fee = "SELECT * FROM student_fee_tbl WHERE std_id ='$std_id'";
                                        $s = mysqli_query($conn, $student_fee);
                                        while ($student_data = mysqli_fetch_array($s)) { ?>
                                <tr>
                                    <td>
                                        <?php echo $sno++ ?>
                                    </td>
                                    <td>
                                        <?php echo $student_data['semester'] ?>
                                    </td>
                                    <td><?php echo $student_data['amount'] ?></td>
                                    <td>
                                        <a href="<?php echo $url . '&del_id=' . $student_data['fee_id']; ?>"
                                            onclick="return confirm('Are you sure to delete this admin?')"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>

                                </tr>
                                <?php }
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;  ?>

    </div>
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>