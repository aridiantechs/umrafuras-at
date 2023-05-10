<style>
    * {
        font-family: 'Open Sans', sans-serif;
        font-size: 110%;
    }
</style>
<?php
if ($_SERVER["HTTP_HOST"] == "localhost") {
    $path = "http://localhost/umrahfuras.com/dashboard/db/";
} else {
    $path = "http://panel.umrahfuras.com/db/";
}
$dir = dirname(__FILE__);

$files = scandir($dir);
foreach ($files as $file) {
    $ext = explode(".", $file);
    if (end($ext) == 'backup' || end($ext) == 'sql') {
        echo "File: " . $file . "<br><a href='" . $path . $file . "'>Download</a><hr>";
    }
}
?>