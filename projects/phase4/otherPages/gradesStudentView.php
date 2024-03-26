<?php
session_start();
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer2.php";

require_once($path . "/database.php");

// Check if the user is not logged in. Send them to index/login page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "projects/phase4/index.php");
    exit();
}

if (isset($_SESSION["confirmationGood"])) {
    unset($_SESSION["confirmationGood"]);
}
if (isset($_SESSION["confirmationBad"])) {
    unset($_SESSION["confirmationBad"]);
}


// Declare variables
$currentCourse = $_SESSION['currentCourse'];
$courseId = "";
$courseTitle = "";

// Get the course code and title
$sql = "SELECT c.courseId, c.courseTitle 
        FROM enrollments e  INNER JOIN course_assignments ca ON e.courseAssignmentId = ca.id
                            INNER JOIN courses c ON ca.courseId = c.id
        WHERE e.id = $currentCourse";
if ($result = mysqli_query($cn, $sql)) {
    $row = mysqli_fetch_row($result);
    $courseId = $row['0'];
    $courseTitle = $row['1'];
}

// Get 

include($header);
?>

<div class="content">
    <h1><?php echo htmlspecialchars($courseId) . " - " . htmlspecialchars($courseTitle) ?></h1>




    <table>
        <thead>
            <tr>
                <th colspan="2">Grade Item</th>
                <th>Points</th>
                <th>Grade</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            <!-- For each grade category -->
            <tr>
                <th colspan="2">Category Name</th>
                <td>&nbsp;</td>
                <td>The Grade</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <th>Grade Item</th>
                <td>9/10</td>
                <td>100%</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include($footer);
?>