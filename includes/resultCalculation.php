<?php
function calculateGpa($marks){

    // create switch statement to chow gpa according to marks
    switch ($marks) {
        case ($marks >= 85):
            return 4.0;
            break;
        case ($marks == 84):
            return 3.9;
            break;
        case ($marks == 83):
            return 3.8;
            break;
        case ($marks == 82):
            return 3.7;
            break;
        case ($marks == 81):
            return 3.6;
            break;
        case ($marks == 80):
            return 3.5;
            break;
        case ($marks >= 78):
            return 3.4;
            break;
        case ($marks >= 76):
            return 3.3;
            break;
        case ($marks >= 74):
            return 3.2;
            break;
        case ($marks == 73):
            return 3.1;
            break;
        case ($marks == 72):
            return 3.0;
            break;
        case ($marks == 71):
            return 2.9;
            break;
        case ($marks == 70):
            return 2.8;
            break;
        case ($marks == 69):
            return 2.7;
            break;
        case ($marks == 68):
            return 2.6;
            break;
        case ($marks >= 66):
            return 2.5;
            break;
        case ($marks >= 64):
            return 2.4;
            break;
        case ($marks == 63):
            return 2.3;
            break;
        case ($marks == 62):
            return 2.2;
            break;
        case ($marks == 61):
            return 2.1;
            break;
        case ($marks == 60):
            return 2.0;
            break;
        case ($marks == 59):
            return 1.9;
            break;
        case ($marks == 58):
            return 1.8;
            break;
        case ($marks == 57):
            return 1.7;
            break;
        case ($marks == 56):
            return 1.6;
            break;
        case ($marks == 55):
            return 1.5;
            break;
        case ($marks == 54):
            return 0.4;
            break;
        case ($marks == 53):
            return 0.3;
            break;
        case ($marks == 52):
            return 0.2;
            break;
        case ($marks == 51):
            return 0.1;
            break;
        case ($marks == 50):
            return 1.0;
            break;
        default:
            return 0;
    }

}

function calculateCGPA($grades) {
    $total_credit_hours = 0;
    $total_grade_points = 0;

    foreach ($grades as $subject => $grade) {
        $credit_hours = $grade['chr'];

        // Calculate grade points
        $grade_points = $credit_hours * $grade['gpa'];

        // Accumulate total credit hours and grade points
        $total_credit_hours += $credit_hours;
        $total_grade_points += $grade_points;
    }


    if($total_grade_points === 0 || $total_credit_hours === 0) return 0;
    else{

        // Calculate CGPA
        $cgpa = round($total_grade_points / $total_credit_hours, 2);
        
        return $cgpa;
    }
}
