<?php
$local = false;
$path = $_SERVER['DOCUMENT_ROOT'];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

$header = $path . "/includes/header.php";
$menu = $path . "/includes/menu.php";
$footer = $path . "/includes/footer.php";
include($header);
include($menu);
?>
<h1>Result</h1>
<?php

$num1 = $_POST['firstNumber'];
$num2 = $_POST['secondNumber'];

function add($a, $b)
{
    return $a + $b;
}

function subtract($a, $b)
{
    return $a - $b;
}

function multiply($a, $b)
{
    return $a * $b;
}

function divide($a, $b)
{
    return $a / $b;
}


if (($num1 == "") || ($num2 == "")) {
    echo "<p>Both numbers must be provided to carry out the arithmetic operation!!!</p>";
} else {
    if (isset($_POST['addBtn'])) {
        echo "<p>" . htmlspecialchars($num1) . " + " . htmlspecialchars($num2) . " = " . htmlspecialchars(add($num1, $num2)) . "</p>";
    } elseif (isset($_POST['subtractBtn'])) {
        echo "<p>" . htmlspecialchars($num1) . " - " . htmlspecialchars($num2) . " = " . htmlspecialchars(subtract($num1, $num2)) . "</p>";
    } elseif (isset($_POST['multiplyBtn'])) {
        echo "<p>" . htmlspecialchars($num1) . " &#215; " . htmlspecialchars($num2) . " = " . htmlspecialchars(multiply($num1, $num2)) . "</p>";
    } elseif (isset($_POST['divideBtn'])) {
        if ($num2 == 0) {
            echo "<p> Divisor cannot be equal to zero.</p>";
        } else {
            echo "<p>" . htmlspecialchars($num1) . " / " . htmlspecialchars($num2) . " = " . htmlspecialchars(divide($num1, $num2)) . "</p>";
        }
    }
}

echo "<button type=\"button\" onclick=\"history.go(-1);\">Back</button>"

?>
<?php
include($footer);
?>