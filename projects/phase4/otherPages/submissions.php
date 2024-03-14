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
<h1>Submissions</h1>
<table style="width: 100%;">
    <tr class="columnHeaders">
        <td>Submission</td>
        <td>Status</td>
        <td>Grade</td>
        <td>Feedback</td>
    </tr>
    <?php
    foreach ($submissions as $submission) {
        echo "<tr>";
        echo "<td><div><a href=''>" . $submission['name'] . "</a></div><div>Submitted Date</div></td>";
        echo "<td class='status'><div>" . $submission['status'] . "</div></td>";
        echo "<td class='grade'><div>" . $submission['grade'] . "</div></td>";
        echo "<td class='feedback'><div><a href=''>" . $submission['feedback'] . "</a></div></td>";
        echo "</tr>";
    }
    ?>
</table>
<?php
include($footer);
?>