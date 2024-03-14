<?php
session_start();
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer2.php";

require_once($path . "/database.php");
// Check if the user is not logged in. Send them to index page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "projects/phase4/index.php");
    exit();
}

if (isset($_POST["returnHome"])) {
    if ($_SESSION["usertype"] == "student") {
        if (isset($_SESSION["confirmationGood"])) {
            unset($_SESSION["confirmationGood"]);
        }
        if (isset($_SESSION["confirmationBad"])) {
            unset($_SESSION["confirmationBad"]);
        }
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
    } else {
        if (isset($_SESSION["confirmationGood"])) {
            unset($_SESSION["confirmationGood"]);
        }
        if (isset($_SESSION["confirmationBad"])) {
            unset($_SESSION["confirmationBad"]);
        }
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeProfessor.php");
    }
}

include($header);
?>
<link rel="stylesheet" href="<?= $docRoot ?>projects/phase4/css/assignments.css">
<h1>Assignments</h1>
<table style="width: 100%;">
    <tr class="columnHeaders">
        <td>Assignment</td>
        <td>Upload Status</td>
        <td>Score</td>
        <td>Feedback</td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/submissions.php">Assignment 1</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">1 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>15 / 15</div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/feedback.php?name=Assignment+1&score=15/15">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/submissions.php">Assignment 2</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">3 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>85 / 100</div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/feedback.php?name=Assignment+2&score=85/100">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/submissions.php">Assignment 3</a>
            </div>
            <div>Due Date</div>
        </td>
        <td class="uploadStatus">
            <div>
                <a href="">not submitted</a>
            </div>
        </td>
        <td class="score">
            <div>- / -</div>
        </td>
        <td class="feedback">
            <div>
                <a href=""></a>
            </div>
        </td>
    </tr>
</table>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type=submit class="btn btn-success" name="returnHome" value="Return to your Home Page">
</form>
<?php
include($footer);
?>