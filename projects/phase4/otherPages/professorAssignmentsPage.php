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
?>
<link rel="stylesheet" href="<?= $docRoot ?>projects/phase4/css/assignments.css">
<h1>Assignments</h1>
<table style="width: 100%;">
    <tr class="columnHeaders">
        <td>Assignment</td>
        <td>Available Date</td>
        <td>Due Date</td>
        <td>Student Submissions</td>
        <td>Edit</td>
    </tr>
    <tr id="assignment 1">
        <td>
            <div class="assignment_name" id>
                <a href="">
                    <p>Assignment 1</p>
                </a>
            </div>
        </td>
        <td>
            <div class="available_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="due_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="student_submissions">
                <a href="<?= $docRoot ?>projects/phase4/otherPages/grading.php?name=Assignment+1">20 / 20</a>
            </div>
        </td>
        <td>
            <button onclick="makeAssignmentEditable('assignment 1')" style="border: none; background: none;">
                <img src="<?= $docRoot ?>projects/phase4/images/edit.png" alt="Edit" style="width: 20px; height: 20px;">
            </button>
        </td>
    </tr>
    <tr id="assignment 2">
        <td>
            <div class="assignment_name">
                <a href="">
                    <p>Assignment 2</p>
                </a>
            </div>
        </td>
        <td>
            <div class="available_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="due_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="student_submissions">
                <a href="<?= $docRoot ?>projects/phase4/otherPages/grading.php?name=Assignment+2">10 / 20</a>
            </div>
        </td>
        <td>
            <button onclick="makeAssignmentEditable('assignment 2')" style="border: none; background: none;">
                <img src="<?= $docRoot ?>projects/phase4/images/edit.png" alt="Edit" style="width: 20px; height: 20px;">
            </button>
        </td>
    </tr>
    <tr id="assignment 3">
        <td>
            <div class="assignment_name">
                <a href="">
                    <p>Assignment 3</p>
                </a>
            </div>
        </td>
        <td>
            <div class="available_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="due_date">
                2024-01-01
            </div>
        </td>
        <td>
            <div class="student_submissions">
                <a href="<?= $docRoot ?>projects/phase4/otherPages/grading.php?name=Assignment+3">- / 20</a>
            </div>
        </td>
        <td>
            <button onclick="makeAssignmentEditable('assignment 3')" style="border: none; background: none;">
                <img src="<?= $docRoot ?>projects/phase4/images/edit.png" alt="Edit" style="width: 20px; height: 20px;">
            </button>
        </td>
    </tr>
</table>
<?php
include($footer);
?>