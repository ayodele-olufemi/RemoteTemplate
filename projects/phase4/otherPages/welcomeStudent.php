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
$studentId = $_SESSION['studentId'];

//prepare sql to get student details
$sql1 = "SELECT firstName, lastName, email, phone, photoUrl FROM students WHERE id = ?";

//prepare sql to get student enrollment details
$sql2 = "SELECT enrollId, studentId, courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail, enrollStatus FROM vw_studentEnrollments WHERE studentId = ?";

//prepare sql to get course available for registration
$sql3 = "SELECT caId, courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail FROM vw_availableEnrollments WHERE courseId NOT IN (SELECT courseId from vw_studentEnrollments WHERE studentId = ?)";

// Execute sql to get student details
if ($stmt1 = mysqli_prepare($cn, $sql1)) {
    mysqli_stmt_bind_param($stmt1, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt1)) {
        mysqli_stmt_store_result($stmt1);
        mysqli_stmt_bind_result($stmt1, $first_name, $last_name, $e_mail, $phone, $photoUrl);
        if (mysqli_stmt_fetch($stmt1)) {
            $_SESSION["firstName"] = $first_name;
            $_SESSION["lastName"] = $last_name;
            $_SESSION["email"] = $e_mail;
            $_SESSION["phone"] = $phone;
            $_SESSION["profilePicture"] = $photoUrl;
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt1);
}

// Execute sql to get student enrollment details
if ($stmt2 = mysqli_prepare($cn, $sql2)) {
    mysqli_stmt_bind_param($stmt2, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt2)) {
        $result = mysqli_stmt_get_result($stmt2);
        if (mysqli_num_rows($result) > 0) {
            $enrollment = "<table class='table table-success table-striped table-hover'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                $ee = $row['enrollStatus'] == 1 ? 'Enrolled' : 'Awaiting Approval';
                $dis = $ee == 'Awaiting Approval' ? 'disabled' : '';
                $enrollment .= "<tr>
                <td>" . $row['courseId'] . "</td>
                <td>" . $row['courseTitle'] . "</td>
                <td>" . $row['courseDescription'] . "</td>
                <td>" . $row['profFirstName'] . " " . $row['profLastName'] . "</td>
                <td>" . $row['profEmail'] . "</td>
                <td>" . $ee . "</td>
                <td>
                    <form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
                        <input type='hidden' name='enrollId' value=" . $row['enrollId'] . ">
                        <input type='submit' class='btn btn-success' value='Check Grade' name='checkGrade' " . $dis . "> <input type='submit' class='btn btn-danger' value='Drop Class' name='dropClass'>
                    </form>
                </td>
                </tr>";
            }
            $enrollment .= "</tbody>
                        </thead>
                    </table>";
        } else {
            $enrollment = "You are not currently enrolled to any class.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt2);
}

// Execute sql to get course available for registration
if ($stmt3 = mysqli_prepare($cn, $sql3)) {
    mysqli_stmt_bind_param($stmt3, "i", $param_studentId);

    $param_studentId = $studentId;

    if (mysqli_stmt_execute($stmt3)) {
        $result = mysqli_stmt_get_result($stmt3);
        if (mysqli_num_rows($result) > 0) {
            $available = "<table class='table table-primary table-striped table-hover'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Instructor</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
                </thead>
            <tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                $available .= "<tr>
                <td>" . $row['courseId'] . "</td>
                <td>" . $row['courseTitle'] . "</td>
                <td>" . $row['courseDescription'] . "</td>
                <td>" . $row['profFirstName'] . " " . $row['profLastName'] . "</td>
                <td>" . $row['profEmail'] . "</td>
                <td>
                    <form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
                        <input type='hidden' name='caId' value=" . $row['caId'] . ">
                        <input type='submit' class='btn btn-primary' value='Enroll' name='enrollNow'>
                    </form>
                </td>
                </tr>";
            }
            $available .= "</tbody>
                    </table>";
        } else {
            $available = "There are currently no classes available. Please check again later.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt3);
}


// function to enroll in a class
if (isset($_POST["enrollNow"])) {
    $courseAssignId = $_POST["caId"];
    $sql1 = "INSERT INTO enrollments (studentId, courseAssignmentId) VALUES ('$studentId', '$courseAssignId')";

    if (mysqli_query($cn, $sql1)) {
        $_SESSION["confirmationGood"] = "Class registered successfully!";
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
    } else {
        $_SESSION["confirmationBad"] = "There was an error enrolling in the class, Please try again later.";
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
    }
}


// function to drop class
if (isset($_POST["dropClass"])) {
    $enrollId = $_POST["enrollId"];

    $sql1 = "DELETE FROM grades WHERE assessmentId IN (SELECT id FROM assessments where enrollmentId = $enrollId)";
    $sql2 = "DELETE FROM assessments WHERE enrollmentId = $enrollId";
    $sql3 = "DELETE FROM enrollments WHERE id = $enrollId";

    if (mysqli_query($cn, $sql1)) {
        if (mysqli_query($cn, $sql2)) {
            if (mysqli_query($cn, $sql3)) {
                $_SESSION["confirmationGood"] = "Class dropped successfully!";
                header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
            }
        }
    } else {
        $_SESSION["confirmationBad"] = "There was an error dropping the class, Please try again later.";
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
    }
}


// function to check grade
if (isset($_POST["checkGrade"])) {
    $_SESSION['currentCourse'] = $_POST["enrollId"];
    header("location: " . $docRoot . "projects/phase4/otherPages/gradesStudentView.php");
}


//TESTING CODE -- PRINT $_SESSION
/* foreach ($_SESSION as $a => $b) {
    echo $a . " => " . $b . " ";
} */

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
    <h1>Student Welcome Page</h1>
    <section>
        <h2>
            <a href="<?= $docRoot ?>projects/phase4/otherPages/assignmentsPage.php">Assignments</a>
        </h2>
    </section>
    <section>
        <h2>Registered Classes</h2>
        <div class="registeredClasses">
            <p><?php echo $enrollment ?></p>
        </div>
    </section>
    <section>
        <h2>Available Classes</h2>
        <div class=" availableClasses">
            <p><?php echo $available ?></p>
        </div>
    </section>
</div>
<?php
include($footer);
?>