<?php
$local = false;
$docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/";

if ($local == false) {
    $docRoot = "http://" . $_SERVER["HTTP_HOST"] . "/~ics325sp2409/";
}
?>

<div class="clearBoth">
    <div class="floatLeft sideBar accordion accordion-flush" id="navAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="homeButton">
                <div class="accordion-button" id="notHome" type="button">Home</div>
            </h2>
            <h2 class="accordion-header" id="headingOne">
                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target=".collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Labs
                </div>
            </h2>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab2\index.php" data-pageName="Lab 2" class="accordion-body linkToSection">Lab 2</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab3\index.php" data-pageName="Lab 3" class="accordion-body linkToSection">Lab 3</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab4\index.php" data-pageName="Lab 4" class="accordion-body linkToSection">Lab 4</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab5\index.php" data-pageName="Lab 5" class="accordion-body linkToSection">Lab 5</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab6\index.php" data-pageName="Lab 6" class="accordion-body linkToSection">Lab 6</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab7\index.php" data-pageName="Lab 7" class="accordion-body linkToSection">Lab 7</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab8\index.php" data-pageName="Lab 8" class="accordion-body linkToSection">Lab 8</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab9\index.php" data-pageName="Lab 9" class="accordion-body linkToSection">Lab 9</a>
            </div>
            <div class="accordion-collapse collapse collapseOne" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>labs\lab10\index.php" data-pageName="Lab 10" class="accordion-body linkToSection">Lab 10</a>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target=".collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    Projects
                </div>
            </h2>
            <div class="accordion-collapse collapse collapseTwo" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>projects\phase1\index.php" data-pageName="Phase 1" class="accordion-body linkToSection">Phase 1</a>
            </div>
            <div class="accordion-collapse collapse collapseTwo" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>projects\phase2\index.php" data-pageName="Phase 2" class="accordion-body linkToSection">Phase 2</a>
            </div>
            <div class="accordion-collapse collapse collapseTwo" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>projects\phase3\index.php" data-pageName="Phase 3" class="accordion-body linkToSection">Phase 3</a>
            </div>
            <div class="accordion-collapse collapse collapseTwo" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>projects\phase4\index.php" data-pageName="Phase 4" class="accordion-body linkToSection">Phase 4</a>
            </div>
            <div class="accordion-collapse collapse collapseTwo" aria-labelledby="headingOne" data-bs-parent="#navAccordion">
                <a href="<?= $docRoot ?>projects\final\index.php" data-pageName="Final" class="accordion-body linkToSection">Final</a>
            </div>
        </div>
    </div>
    <div class="floatRight content">