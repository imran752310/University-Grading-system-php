<?php

include('includes/header.php');
include('includes/navbar.php');
include('includes/top_bar.php');
include('../includes/resultCalculation.php');

$sno = 1;
$std_id = $_SESSION['id'];
$select_query = "SELECT r.*, c.* FROM `result_tbl` r
INNER JOIN `student_course_tbl` sc ON r.`student_course_id` = sc.`student_course_id`
INNER JOIN `course_tbl` c ON sc.`course_id` = c.`course_id`
WHERE sc.`student_id` = '$std_id' AND r.`show_status` = 1";
$res = mysqli_query($conn, $select_query);
$totalGrades = [];
?>

<!-- Begin Page Content -->
<div class="container">
    <div class="card shadow mb-4" style="border-radius: 40px;">
        <div class="card-header py-3" style="border-radius: 40px;">
            <h6 class="m-0 font-weight-bold text-primary">Marks Sheet</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S no</th>
                            <th>Subject</th>
                            <th>Credit Hr</th>
                            <th>Mid</th>
                            <th>Quiz</th>
                            <th>Assignment</th>
                            <th>Final</th>
                            <th>Obtained</th>
                            <th>Total</th>
                            <th>GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($course = mysqli_fetch_array($res)) :
                            $total = $course['mid_marks'] +
                                $course['quizz_marks'] +
                                $course['assigment_m'] +
                                $course['final_marks'];
                            $gpa = calculateGpa($total);
                            array_push($totalGrades, array(
                                'chr' => $course['chr'],
                                'gpa' => $gpa
                            ));
                        ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $course['title']; ?></td>
                            <td><?php echo $course['chr']; ?></td>
                            <td><?php echo $course['mid_marks']; ?></td>
                            <td><?php echo $course['quizz_marks']; ?></td>
                            <td><?php echo $course['assigment_m']; ?></td>
                            <td><?php echo $course['final_marks']; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $course['total_marks']; ?></td>
                            <td><?php echo $gpa ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <h2 class="text-center text-primary font-weight-bold">
                    Your CGPA is: <?php echo calculateCGPA($totalGrades); ?>
                </h2>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>