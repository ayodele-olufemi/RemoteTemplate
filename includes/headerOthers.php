<html lang="en">
<?php
$local = false;
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}
require_once($path . "/database.php");
?>

<head>
    <meta charset="utf-8" />
    <title>GradeBook App - Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="<?= $docRoot ?>projects/phase4/js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= $docRoot ?>projects/phase4/css/styles.css" />
</head>

<body>
    <div class="heading">
        <a href="<?= $docRoot ?>projects/phase4/index.php">
            <img src="<?= $docRoot ?>projects/phase4/images/G-oneLogo.png" class="g_one_logo" alt="G-One Logo">
        </a>
        <a href="<?= $docRoot ?>index.php">
            <img src="<?= $docRoot ?>projects/phase4/images/back.png" alt="Back to Class Site">
        </a>
    </div>
    <hr>