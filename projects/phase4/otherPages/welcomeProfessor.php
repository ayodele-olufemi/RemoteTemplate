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
$professorId = $_SESSION['professorId'];

//prepare sql to get professor details
$sql1 = "SELECT firstName, lastName, email, phone, photoUrl FROM professors WHERE id = ?";

//prepare sql to get my courses
$sql2 = "SELECT c.courseId, c.courseTitle, COUNT";


// Execute sql to get professor details
if ($stmt1 = mysqli_prepare($cn, $sql1)) {
    mysqli_stmt_bind_param($stmt1, "i", $param_professorId);

    $param_professorId = $professorId;

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
    <h1>Professor Welcome Page</h1>
    <section>
        <h2>My Courses</h2>
        <div class="myCourses">
            <p><?php echo $myCourses ?></p>
        </div>
    </section>
    <?php
    echo "<p>The ProfessorId is " . $_SESSION["professorId"] . "</p>";
    ?>

    <table class='table table-primary table-striped table-hover'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Enrolled</th>
                <th>Pending</th>
                <th>Seats Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>CSCI101</td>
                <td>Computer</td>
                <td>7</td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>CSCI101</td>
                <td>Computer</td>
                <td>7</td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td><input type="button" value="Approve"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>CSC2101</td>
                <td>Computer</td>
                <td>7</td>
                <td>0</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <section>
        <h2>
            <a href="<?= $docRoot ?>projects/phase4/otherPages/professorAssignmentsPage.php">Assignments</a>
        </h2>
    </section>

</div>
<?php
include($footer);
?>