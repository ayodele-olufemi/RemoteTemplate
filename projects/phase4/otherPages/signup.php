<?php
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}
if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}

$header = $path . "/includes/headerOthers.php";
$footer = $path . "/includes/footer2.php";

include($header);

// Include config file
require_once($path . "/database.php");

// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname = $phone = $email = $usertype = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = $phone_err = $email_err = $usertype_err = "";

// Processing form data when sign-up form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usertype = $_POST["usertype"];
    // Validate username and email
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email";
    } else {
        // Prepare a select statement
        if ($usertype == "students") {
            $sql1 = "SELECT id FROM auth_table WHERE username = ?";
            $sql2 = "SELECT id FROM students WHERE email = ?";
        } else {
            $sql1 = "SELECT id FROM auth_table WHERE username = ?";
            $sql2 = "SELECT id FROM professors WHERE email = ?";
        }

        $sql = "SELECT id FROM auth_table WHERE username = ?";

        if ($stmt = mysqli_prepare($cn, $sql1)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        if ($stmt = mysqli_prepare($cn, $sql2)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "A " . ucfirst(substr($usertype, 0, -1)) . " with this email already exists. <br> Retrieve your login details here.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate first name
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter your first name.";
    } elseif (!preg_match('/^[a-z]*$/i', trim($_POST["firstname"]))) {
        $firstname_err = "Please enter a valid first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    // Validate last name
    if (empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter your first name.";
    } elseif (!preg_match('/^[a-z]*$/i', trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a valid last name.";
    } else {
        $lastname = trim($_POST["lastname"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

        // Prepare an insert statement
        $sql1 = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($usertype == "students") {
            $sql1 = "INSERT INTO auth_table (studentId, username, password_hash) VALUES (?, ?, ?)";
            $sql2 = "INSERT INTO students (firstName, lastName, email, phone) VALUES (?, ?, ?, ?)";
        } else {
            $sql1 = "INSERT INTO auth_table (professorId, username, password_hash) VALUES (?, ?, ?)";
            $sql2 = "INSERT INTO professors (firstName, lastName, email, phone) VALUES (?, ?, ?, ?)";
        }

        if ($stmt2 = mysqli_prepare($cn, $sql2)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "ssss", $param_firstname, $param_lastname, $param_email, $param_phone);

            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_phone = trim($_POST["phone"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt2)) {
                $lastInsertedId = mysqli_insert_id($cn);

                if ($stmt1 = mysqli_prepare($cn, $sql1)) {
                    // Bind variables to the prepared statement as parameters
                    if ($usertype == "students") {
                        mysqli_stmt_bind_param($stmt1, "iss", $param_studentId, $param_username, $param_password);
                        $param_studentId = $lastInsertedId;
                    } else {
                        mysqli_stmt_bind_param($stmt1, "iss", $param_professorId, $param_username, $param_password);
                        $param_professorId = $lastInsertedId;
                    }

                    // Set other parameters
                    $param_username = $username;
                    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt1)) {
                        // Redirect to login page
                        echo "Registration successful! Redirecting to login page.";
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    // Close statement
                    mysqli_stmt_close($stmt1);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt2);
            // Redirect to login page
            header("refresh:5; url=" . $docRoot . "projects/phase4/index.php");
        }
    }

    // Close connection
    mysqli_close($cn);
}
?>
<div class="content">
    <h1>Create an account</h1>
    <p>Please fill this form to create a <b>G-one</b> account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>

        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
            <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
            <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
            <span class="invalid-feedback"><?php echo $phone_err; ?></span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group">
            <label for="usertype">User Type</label>
            <select name="usertype" class="form-control <?php echo (!empty($usertype_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usertype; ?>">
                <option value="students">Student</option>
                <option value="professors">Professor</option>
            </select>
            <span class="invalid-feedback"><?php echo $usertype_err; ?></span>
        </div>

        <div class="form-group" style="margin-top: 70px;">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <p>Already have an account? Click <a href="<?= $docRoot ?>projects/phase4/index.php">here</a> to login.</p>
    </form>
</div>
<?php
include($footer);
?>