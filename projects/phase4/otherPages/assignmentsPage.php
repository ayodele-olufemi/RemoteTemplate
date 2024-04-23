<!DOCTYPE html>
<?php
session_start();
$local = true;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/project/phase2/includes/headerLoggedIn.php";
$footer = $path . "/project/phase2/includes/footer2.php";

require_once($path . "/database.php");
// Check if the user is not logged in. Send them to index page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "project/phase2/index.php");
    exit();
}
include($header);

if (isset($_POST["returnHome"])) {
    if ($_SESSION["usertype"] == "student") {
        if (isset($_SESSION["confirmationGood"])) {
            unset($_SESSION["confirmationGood"]);
        }
        if (isset($_SESSION["confirmationBad"])) {
            unset($_SESSION["confirmationBad"]);
        }
        header("location: " . $docRoot . "/project/phase2/otherPages/welcomeStudent.php");
    } else {
        if (isset($_SESSION["confirmationGood"])) {
            unset($_SESSION["confirmationGood"]);
        }
        if (isset($_SESSION["confirmationBad"])) {
            unset($_SESSION["confirmationBad"]);
        }
        header("location: " . $docRoot . "/project/phase2/otherPages/welcomeProfessor.php");
    }
}

// declare variables 
$studentId = $_SESSION['studentId'];

// prepare sql to get assignment details
$sql1 = "SELECT a.assessmentItemName as assignmentName, a.id, gc.categoryName, g.student_submission as submission, g.score, gc.maxObtainable as maxScore, DATE_FORMAT(a.dueDate, '%M %d, %Y' ) as dueDate from grade_categories gc 
INNER JOIN assessments a on a.gradeCategoryId = gc.id 
INNER JOIN grades g on g.assessmentId = a.id 
where enrollmentId = ?;";

// Execute sql to get course assignment information
if($stmt1 = mysqli_prepare($cn, $sql1)){
    mysqli_stmt_bind_param($stmt1, "i", $param_studentId);

    $param_studentId = $studentId;

    if(mysqli_stmt_execute($stmt1)){
        $result = mysqli_stmt_get_result($stmt1);
        if(mysqli_num_rows($result) > 0){
            $available = "
            <table style='width: 100%;'>
                <thead>
                    <tr>
                        <th>Assignment</td>
                        <th>Upload Status</td>
                        <th>Score</td>
                        <th>Feedback</td>
                    </tr>
                </thead>
                <tbody>";
                while($row = mysqli_fetch_assoc($result)){
                    $available .= "
                    <tr>
                        <td>
                            <div class='name'>
                                <a href='".$docRoot."project/phase2/otherPages/submissions.php'>". $row['assignmentName']."</a>
                            </div>
                            <div>Due Date: ". $row['dueDate']."</div>
                        </td>
                        <td class='uploadStatus'>
                            <div>
                                <a href='".$docRoot."project/phase2/otherPages/submissions.php'>". $row['submission']."</a>
                            </div>
                        </td>
                        <td class='score'>
                            <div>". $row['score']." / ".$row['maxScore']."</div>
                        </td>
                        <td class='feedback'>
                            <div>
                                <a href='".$docRoot."project/phase2/otherPages/feedback.php?name=".$row['id']."&score=". $row['score']."/".$row['maxScore']."'>unread</a>
                            </div>
                        </td>
                    </tr>
                    ";
                }
                $available .= "
                        </tbody>
                    </table>";
        } else{
            $available = "There are currently no assignments available.";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt1);
}


?>
<link rel="stylesheet" href="<?php echo $docRoot; ?>project/phase2/css/assignments.css">
<h1>Assignments</h1>
<p><?php echo $available ?></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type=submit class="btn btn-success" name="returnHome" value="Return to your Home Page">
    </form>
<?php
include($footer);
?>