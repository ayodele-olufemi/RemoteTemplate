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

include($header);


$assignmentNameFromURL = isset($_GET['name']) ? $_GET['name'] : 'DefaultAssignmentName';

?>

<link rel="stylesheet" href="<?= $docRoot ?>projects/phase4/css/assignments.css">
<h1>Grade</h1>
<table style="width: 100%;">
    <tr class="columnHeaders">
        <td>Student</td>
        <td>Upload Status</td>
        <td>Score</td>
        <td>Feedback</td>
    </tr>
    <tr>
        <td>
            <div>
                <p>John Doe</p>
            </div>

        </td>
        <td class="uploadStatus">
            <div>
                <a href="">1 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>
                <input type="text" class="editable-score" value="15" style="width: 40px;"> / 15
            </div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/feedback.php?name=<?php echo urlencode($assignmentNameFromURL); ?>">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <p>Jane Smith</p>
            </div>

        </td>
        <td class="uploadStatus">
            <div>
                <a href="">1 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>
                <input type="text" class="editable-score" value="15" style="width: 40px;"> / 15
            </div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/feedback.php?name=<?php echo urlencode($assignmentNameFromURL); ?>">unread</a>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <p>Robert Jackson</p>
            </div>

        </td>
        <td class="uploadStatus">
            <div>
                <a href="">1 submission(s)</a>
            </div>
        </td>
        <td class="score">
            <div>
                <input type="text" class="editable-score" value="15" style="width: 40px;"> / 15
            </div>
        </td>
        <td class="feedback">
            <div>
                <a href="<?= $docRoot ?>projects/phase4/otherPages/feedback.php?name=<?php echo urlencode($assignmentNameFromURL); ?>">unread</a>
            </div>
        </td>
    </tr>
</table>
<button id="updateScores" style="margin-top: 20px;">Update</button>
<?php
include($footer);
?>