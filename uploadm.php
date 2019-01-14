<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    require_once("vendor/autoload.php");

    $files = $_FILES['files'];

    use \BlackBeard\BUploader\UploaderMultiple;
    
    $e = new UploaderMultiple("files/", array("all"), 5, "como fazer isso");
    $e->setMultipleValues($files);
    $a = $e->uploadAll();
    echo "<pre>";
    var_dump($a);
    echo "</pre>";