<?php
session_start();
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerLoggedIn.php";
$footer = $path . "/includes/footer2.php";

require_once($path . "/database.php");

// Check if the user is not logged in. Send them to index/login page
if (!isset($_SESSION["loggedin"])) {
    header("location: " . $docRoot . "projects/phase4/index.php");
    exit();
}


if (isset($_SESSION["confirmationGood"]) || isset($_SESSION["confirmationBad"])) {
    echo '<script type="text/Javascript">
    setTimeout(() => {
        document.querySelector(".confirmation").style.display="none";
    }, 3000);
    </script>';
}


// declare variables 
$currentCourse = $_SESSION['currentCourse'];
$courseID = $courseTitle = $courseDescription = "";

$sql1 = "SELECT c.courseId AS `courseId`, c.courseTitle AS `courseTitle`, c.courseDescription AS `courseDescription` 
         FROM enrollments e INNER JOIN course_assignments ca ON e.courseAssignmentId = ca.id
                            INNER JOIN courses c ON ca.courseId = c.id
         WHERE e.id = $currentCourse";
if ($result = mysqli_query($cn, $sql1)) {
    $row = mysqli_fetch_row($result);
    $courseID = $row['0'];
    $courseTitle = $row['1'];
    $courseDescription = $row['2'];
}

// function to go view course materials
if (isset($_POST["gotoCourseMaterials"])) {
    $_SESSION['currentCourse'] = $_POST["enrollId"];
    header("location: " . $docRoot . "projects/phase4/otherPages/studentCourseHome.php");
}

// function to go view assignments
if (isset($_POST["gotoAssignments"])) {
    $_SESSION['currentCourse'] = $_POST["enrollId"];
    header("location: " . $docRoot . "projects/phase4/otherPages/assignmentsPage.php");
}

// function to go view grades
if (isset($_POST["gotoGrades"])) {
    $_SESSION['currentCourse'] = $_POST["enrollId"];
    header("location: " . $docRoot . "projects/phase4/otherPages/gradesStudentView.php");
}


include($header);


?>
<div class="content">
    <div class="confirmation" style="margin-bottom: 2rem;">
        <h2 style="color: red">
            <?php if (isset($_SESSION["confirmationBad"])) {
                echo htmlspecialchars($_SESSION["confirmationBad"]);
            }  ?>
        </h2>
        <h2 style="color: green">
            <?php if (isset($_SESSION["confirmationGood"])) {
                echo htmlspecialchars($_SESSION["confirmationGood"]);
            } ?>
        </h2>
    </div>
    <h1><?php echo $courseID . ": " . $courseTitle ?></h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="submit" class="btn btn-primary" name="gotoCourseMaterials" value="Course Materials">
        <input type="submit" class="btn btn-warning" name="gotoAssignments" value="Assignments">
        <input type="submit" class="btn btn-success" name="gotoAssignments" value="Quizzes">
        <input type="submit" class="btn btn-dark" name="gotoGrades" value="Grades">
    </form>
    <section>
        <h2>Course Description</h2>
        <p><?php echo $courseDescription ?></p>
    </section>
    <section>
        <h2>Course Syllabus</h2>
        <embed src="<?= $docRoot ?>projects/phase4/uploads/Syllabus1.pdf" type="application/pdf" frameBorder="0" scrolling="auto" height="100%" width="100%">
    </section>
</div>
<?php
include($footer);
?>