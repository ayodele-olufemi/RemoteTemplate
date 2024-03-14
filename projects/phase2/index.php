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
<p>This is a placeholder for <span id="folderName"></span></p>

<?php
include($footer);
?>