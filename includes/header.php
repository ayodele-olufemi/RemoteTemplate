<html lang="en">
<?php
$local = false;
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}
?>

<head>
    <meta charset="utf-8" />
    <title>Ayodele Olufemi's Site</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="<?= $docRoot ?>js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= $docRoot ?>css/style.css" />
</head>

<body>

    <div class="clearBoth header">
        <div class="floatLeft carousel slide" data-bs-ride="carousel" id="imageCarousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="60000">
                    <img src="<?= $docRoot ?>images/mkbhd.png" class="d-block w-100" alt="MKBHD" />
                </div>
                <div class="carousel-item" data-bs-interval="60000">
                    <img src="<?= $docRoot ?>images/united.png" class="d-block w-100" alt="Manchester United Logo" />
                </div>
                <div class="carousel-item" data-bs-interval="60000">
                    <img src="<?= $docRoot ?>images/food.png" class="d-block w-100" alt="Amala and Abula" />
                </div>
                <div class="carousel-item" data-bs-interval="60000">
                    <img src="<?= $docRoot ?>images/rnb.png" class="d-block w-100" alt="Rythm and Blues" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="floatLeft headerTexts">
            <h1 id="title">Ayodele's Site</h1>
            <h3 class="subtitle">Home</h3>
        </div>
        <div class="headerRightItems floatRight">
            <div class="floatRight" id="metroLogo">
                <img src="<?= $docRoot ?>images/metroLogo.png" style="height: 80px" />
            </div>
            <div class="floatRight" id="profilePicture"></div>
            <div class="floatRight" id="colors">
                <table class="colorTable">
                    <tr>
                        <td>
                            <div id="redColor"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="blueColor"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="greenColor"></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>