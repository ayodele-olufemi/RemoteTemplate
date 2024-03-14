<?php
$local = false;
$path = $_SERVER["DOCUMENT_ROOT"];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/headerOthers.php";
$footer = $path . "/includes/footer2.php";

include($header);

// Check if the user is already logged in. Change header to headerLoggedIn.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["usertype"] == "student") {
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
    } else if ($_SESSION["usertype"] == "professor") {
        header("location: " . $docRoot . "projects/phase4/otherPages/welcomeProfessor.php");
    }
    exit;
}


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST["loginBtn"])) {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password_hash, studentId, professorId FROM auth_table WHERE username = ?";

        if ($stmt = mysqli_prepare($cn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $studentId, $professorId);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;

                            if (!empty($studentId)) {
                                //user is student
                                $_SESSION["usertype"] = "student";
                                $_SESSION["studentId"] = (int)$studentId;

                                // Redirect user to welcome page
                                header("location: " . $docRoot . "projects/phase4/otherPages/welcomeStudent.php");
                            } else {
                                //user is professor
                                $_SESSION["usertype"] = "professor";
                                $_SESSION["professorId"] = (int)$professorId;

                                // Redirect user to welcome page
                                header("location: " . $docRoot . "projects/phase4/otherPages/welcomeProfessor.php");
                            }
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($cn);
}
?>
<div class="content">
    <h1>Home Page</h1>
    <h2>For testing purposes only!</h2>
    <p>Student username: test password: testtesttest</p>
    <p>Professor username: professortest password: testtesttest</p>
    <div class="loginForm">
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <br>
            <span class="invalid-feedback"><?php echo $username_err; ?></span><br>

            <label for="password">Password: </label>
            <input type="password" name="password" id="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>

            <p>Forgot your password? Click <a href="<?= $docRoot ?>projects/phase4/otherPages/resetpassword.php">here</a> to reset it.
            </p>
            <input type="submit" name="loginBtn" class="btn btn-primary" value="Login">
        </form>
    </div>
    <div class="callToSignUp">
        <p>Don't have an account? Click <a href="<?= $docRoot ?>projects/phase4/otherPages/signup.php">here</a> to
            create one now!</p>
    </div>
    <div>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint enim doloribus, omnis eius magni voluptate dicta
        tempore alias, soluta tempora dolorem doloremque, cumque autem consequatur dolores illum voluptatum. Culpa,
        obcaecati.
        Eius ipsam nemo unde molestiae veniam perspiciatis provident officia voluptatum, corporis quis necessitatibus
        similique, molestias aut sequi odio quod! A, assumenda eligendi! Voluptatum molestias quisquam facere? Sit
        cumque officia ad?
        Quas repudiandae illum neque voluptatum laboriosam cum est odit voluptates voluptatem, vero reprehenderit dolor
        nesciunt molestiae, qui tenetur optio similique maiores nisi fuga expedita, omnis corporis suscipit enim quam?
        Saepe?
        Impedit quisquam culpa numquam accusamus officiis veritatis ab tempora sint maxime fugiat amet placeat
        necessitatibus nihil, fugit laudantium, harum reprehenderit illo autem velit quaerat explicabo. Reprehenderit
        fuga iusto nobis cum.
        Dicta, a vero dolores accusamus quasi repellendus facere eos quae delectus error est assumenda vitae ad
        reprehenderit ipsam quam sint iure perferendis facilis dignissimos pariatur incidunt adipisci optio blanditiis!
        Et?
        Vitae dolor temporibus quo aliquam totam ex, iure, dignissimos qui ipsam sed eius illo cum numquam magni ipsa
        perferendis dolorum. Dignissimos, eius fugit neque possimus nam sed rerum reprehenderit perspiciatis.
        Blanditiis eligendi quos architecto, cum nemo delectus quas doloribus et, corrupti voluptatum provident quisquam
        omnis nisi, excepturi harum natus voluptates? Ullam quis maiores, numquam doloremque laboriosam laudantium
        assumenda aut culpa?
        Vero consectetur perspiciatis non culpa excepturi deserunt iste soluta vel quidem labore repudiandae praesentium
        rem accusamus fugit sit, laboriosam amet a veniam totam aperiam accusantium tempora similique quos! Molestiae,
        illo.
        Quod, ab distinctio delectus suscipit architecto nisi nostrum hic minima, omnis id minus tempora magni cumque!
        In possimus optio adipisci voluptatibus omnis? Nam sit facilis ducimus deserunt, pariatur magni animi!
        Aut inventore perspiciatis ducimus nobis rem vel quae adipisci ullam nemo quasi nisi optio eum natus assumenda
        perferendis laboriosam molestiae, facere tempora labore totam animi illo provident eaque. Quasi, velit.
        Iure explicabo sed sunt quo itaque nostrum dolore quam expedita. Ad officiis quas dolores, ex iste ea nulla.
        Nihil incidunt et ea laboriosam quas molestiae, hic neque? Tempore, minus consequatur!
        Earum cumque quibusdam exercitationem ab dolorum ea adipisci accusamus eum consequatur ut laborum, facilis
        necessitatibus est magni facere quisquam. Mollitia at dolore nobis blanditiis quae atque corporis? Eveniet, eos
        nihil.
        Voluptates quae, perferendis dolores neque molestias nobis corrupti maxime voluptatibus quibusdam ducimus itaque
        laudantium beatae expedita repellendus odit. Reprehenderit consequatur asperiores necessitatibus quos itaque ad
        quam praesentium cupiditate iusto hic.
        Atque, optio cupiditate similique, pariatur repellat, quaerat doloremque nulla sint quis labore non eaque
        tenetur fugiat veritatis ipsa totam autem id. Recusandae ea ex cum omnis nemo accusantium voluptates aperiam!
        Optio sunt eveniet non sit placeat a iure debitis provident temporibus cupiditate repellendus error dicta, ad
        animi modi quae atque recusandae? Quibusdam iure perspiciatis quam nesciunt velit, exercitationem laboriosam
        consequatur.
        Quia, ducimus repellat. Rem laborum dolor veritatis tempora laudantium inventore error, culpa dolorem dolores,
        magni, reprehenderit beatae blanditiis quasi recusandae minima deleniti sunt facilis? Vel error porro deserunt
        sint officiis!
        Aliquid quia iure modi nulla facere sapiente odit at excepturi aut. Natus quasi veniam nostrum, animi, porro
        cupiditate nemo a numquam accusantium incidunt totam ad et, cumque quod qui ipsam?
        Vero, ea! Nemo debitis quisquam cum. Pariatur reiciendis impedit nostrum corporis. Dolore illum excepturi,
        mollitia ab, quas dolorem neque culpa pariatur provident, natus doloremque nihil consectetur! Tempora laboriosam
        nesciunt natus.
        Ipsa quo laudantium tempore velit voluptatum labore reprehenderit sed accusantium veritatis corporis nostrum,
        sit vitae nihil voluptatem ex maiores voluptatibus enim illum tenetur. Fuga eius tempora animi labore possimus
        nemo.
        Aliquid quaerat modi ab ut asperiores eveniet ex tempore accusamus, quo tempora id dolorum reprehenderit alias
        culpa vero. Iure provident amet repudiandae et ex quibusdam autem est aspernatur quas beatae.
        Veniam atque facilis laborum beatae sint vitae laboriosam minima unde nulla quos quas veritatis voluptatum
        quaerat nam ea, voluptas non vero dolore quibusdam quis! Nesciunt voluptatum quae accusamus enim sunt.
        Velit error beatae aut sit explicabo, tenetur labore quod quaerat id fuga ad recusandae, asperiores officia
        ducimus nulla, alias adipisci blanditiis. Iste magni temporibus aperiam beatae tempora odio mollitia corporis.
        Laudantium porro officiis nesciunt aut ratione maiores neque natus ab necessitatibus beatae quia nostrum, magnam
        aliquid harum, reiciendis sed. Dignissimos quo dolorem cumque autem temporibus velit sint, reprehenderit modi
        quidem.
        Quasi libero delectus aperiam! Id eos iure, eligendi quia sed enim sit? Magni illum fuga aliquam aut amet sint
        eligendi eum quia. Vitae similique dolore reiciendis cumque laudantium. Voluptatem, asperiores.
        Fuga doloribus autem quod quasi officia consectetur consequatur nobis ex ipsam odit voluptatibus rem, nesciunt
        neque vitae? Tenetur accusantium necessitatibus reprehenderit molestiae modi nisi ea minima voluptate alias.
        Tempore, enim?
        Culpa explicabo numquam odio soluta suscipit. Aspernatur dignissimos harum ducimus vero ipsum nam voluptas quod
        architecto odio voluptates illum error, dicta enim suscipit repellendus fugiat soluta obcaecati reprehenderit
        porro quae.
        Est delectus similique, assumenda a tempore, recusandae inventore impedit, deserunt officiis asperiores adipisci
        quam nihil laudantium veritatis iusto nostrum dolorum eius ea error! Eos ab quod sunt natus cum nulla?
        Similique nobis, officia ut pariatur maiores temporibus voluptates mollitia nihil amet nulla earum excepturi
        nisi hic numquam saepe obcaecati iusto maxime consequuntur soluta. Quia neque reprehenderit dolor, incidunt enim
        itaque!
        Blanditiis deserunt sunt, ad beatae, consequuntur dolorum dolore voluptates tempore corporis fuga, at quia
        animi. Incidunt quam culpa neque ratione mollitia, inventore expedita nihil, excepturi perferendis reprehenderit
        quos perspiciatis impedit.
        Quibusdam repellendus, repellat neque sapiente sed nostrum omnis quod adipisci dolore, mollitia rerum quos. Ex
        architecto blanditiis, voluptatem id tempora totam libero dicta asperiores? Deserunt at maxime ducimus. Quam,
        sapiente.
        Nesciunt sapiente rerum officia, sint accusantium magnam. Ex odio dicta aliquam nesciunt ipsum! Maxime fugiat
        incidunt in voluptatibus libero vero numquam obcaecati, quas dignissimos. Ab expedita adipisci nihil corporis
        et?
        Omnis labore laudantium cum error at maiores, dolorum perspiciatis voluptatem consectetur nam maxime doloribus
        repellendus quod quibusdam itaque? Distinctio sequi cum voluptatum impedit praesentium voluptates doloremque
        qui. Culpa, nemo ab.
        Perferendis ducimus iste nihil totam, qui eveniet perspiciatis explicabo autem illo officiis, molestias soluta
        adipisci at natus. Quia, saepe modi debitis aut neque autem rem odit cupiditate fuga quis officia!
        Inventore voluptate officiis ab porro rerum explicabo nemo cupiditate. Dolor fugiat deleniti itaque nemo
        voluptates consequuntur est nam perferendis ea, tempora cumque similique quod ipsum officiis sint hic, tempore
        illum?
        Illum animi placeat excepturi velit rerum vero totam quidem veritatis aliquam dicta obcaecati corporis unde
        reiciendis illo, alias cupiditate odit quo, tempore accusantium ipsa explicabo quibusdam temporibus? Impedit,
        perspiciatis. Consectetur.
        Harum possimus ea quidem quaerat aut deserunt odit unde debitis, sequi, quisquam expedita est culpa iure, itaque
        nihil consequatur error temporibus voluptatum. Praesentium qui odio ex. Corrupti natus non voluptatum!
        Qui veniam error autem officiis commodi? Nam accusantium similique cumque, exercitationem laboriosam delectus
        ipsam suscipit distinctio iusto iure vel tenetur, pariatur porro eligendi nostrum a quod, inventore ab at hic?
        Earum facilis soluta numquam et asperiores minus iste voluptatum reiciendis rerum ullam maxime tempore dolorem
        magnam, tempora, doloremque reprehenderit ea! Ullam unde ratione maxime inventore consequatur sed labore eveniet
        reiciendis!
        Perspiciatis aut repudiandae, est quas ullam suscipit a. Aut, quia. Sapiente quidem dolores ad, ipsa rem ipsum
        ullam, nulla quasi ut fugit, id quaerat saepe sunt deleniti natus veniam eligendi!
    </div>
</div>
<?php
include($footer);
?>