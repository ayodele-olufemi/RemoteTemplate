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

// declare variables 
$assignmentName  = htmlspecialchars($_GET['name']);

$studentScore = '';
$maxScore = '';
if (isset($_GET['score']) && strpos($_GET['score'], '/') !== false) {
    $scores = explode('/', htmlspecialchars($_GET['score']));
    if (count($scores) == 2) {
        $studentScore = $scores[0];
        $maxScore = $scores[1];
    }
}

include($header);


?>
<div>
    <a href="<?php echo $docRoot; ?>projects/phase4/otherPages/assignmentsPage.php">
        < assignments</a>
</div>
<div class="content">
    <?php if ($_SESSION["usertype"] == "professor") : ?>
        <div class="feedback" contenteditable="true">
        <?php else : ?>
            <div class="feedback">
            <?php endif; ?>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint enim doloribus, omnis eius magni voluptate
                dicta tempore alias, soluta tempora dolorem doloremque, cumque autem consequatur dolores illum
                voluptatum. Culpa, obcaecati.
                Eius ipsam nemo unde molestiae veniam perspiciatis provident officia voluptatum, corporis quis
                necessitatibus similique, molestias aut sequi odio quod! A, assumenda eligendi! Voluptatum molestias
                quisquam facere? Sit cumque officia ad?
                Quas repudiandae illum neque voluptatum laboriosam cum est odit voluptates voluptatem, vero
                reprehenderit dolor nesciunt molestiae, qui tenetur optio similique maiores nisi fuga expedita, omnis
                corporis suscipit enim quam? Saepe?
                Impedit quisquam culpa numquam accusamus officiis veritatis ab tempora sint maxime fugiat amet placeat
                necessitatibus nihil, fugit laudantium, harum reprehenderit illo autem velit quaerat explicabo.
                Reprehenderit fuga iusto nobis cum.
                Dicta, a vero dolores accusamus quasi repellendus facere eos quae delectus error est assumenda vitae ad
                reprehenderit ipsam quam sint iure perferendis facilis dignissimos pariatur incidunt adipisci optio
                blanditiis! Et?
                Vitae dolor temporibus quo aliquam totam ex, iure, dignissimos qui ipsam sed eius illo cum numquam magni
                ipsa perferendis dolorum. Dignissimos, eius fugit neque possimus nam sed rerum reprehenderit
                perspiciatis.
                Blanditiis eligendi quos architecto, cum nemo delectus quas doloribus et, corrupti voluptatum provident
                quisquam omnis nisi, excepturi harum natus voluptates? Ullam quis maiores, numquam doloremque laboriosam
                laudantium assumenda aut culpa?
                Vero consectetur perspiciatis non culpa excepturi deserunt iste soluta vel quidem labore repudiandae
                praesentium rem accusamus fugit sit, laboriosam amet a veniam totam aperiam accusantium tempora
                similique quos! Molestiae, illo.
                Quod, ab distinctio delectus suscipit architecto nisi nostrum hic minima, omnis id minus tempora magni
                cumque! In possimus optio adipisci voluptatibus omnis? Nam sit facilis ducimus deserunt, pariatur magni
                animi!
                Aut inventore perspiciatis ducimus nobis rem vel quae adipisci ullam nemo quasi nisi optio eum natus
                assumenda perferendis laboriosam molestiae, facere tempora labore totam animi illo provident eaque.
                Quasi, velit.
                Iure explicabo sed sunt quo itaque nostrum dolore quam expedita. Ad officiis quas dolores, ex iste ea
                nulla. Nihil incidunt et ea laboriosam quas molestiae, hic neque? Tempore, minus consequatur!</p>
            </div>
            <div class="score">
                <span>Score</span>
                <p><?= $studentScore ?> / <?= $maxScore ?> </p>
            </div>
        </div>
        <?php
        include($footer);
        ?>