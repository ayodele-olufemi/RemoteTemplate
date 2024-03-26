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
<form action="<?= $docRoot ?>labs/lab3/calculate.php" method="post">
    <label for="firstNumber">First Number:</label>
    <input type="number" name="firstNumber" required><br>
    <label for="secondNumber">Second Number:</label>
    <input type="number" name="secondNumber" required><br> <br>
    <button type="submit" name="addBtn">Add</button>
    <button type="submit" name="subtractBtn">Subtract</button>
    <button type="submit" name="multiplyBtn">Multiply</button>
    <button type="submit" name="divideBtn">Divide</button>
    <div id="errorMessage"></div>
</form>

<style>
label {
    width: 180px;
    padding-bottom: 10px;
}

input {
    width: 100px;

}

button {
    width: 100px;
    background-color: blue;
    color: white;
    border-radius: 5px;
}

button:hover {
    background-color: red;
}
</style>

<?php
include($footer);
?>