<?php

ini_set('max_execution_time', 120);

require __DIR__ . "/vendor/autoload.php";

$zipPHP = (new LFGuerino\ZipPHP\ZipPHP);

if (!empty($_GET['download'])) {
    $fileName = filter_var($_GET['download'], FILTER_SANITIZE_STRIPPED);
    $zipPHP->download($fileName);
    die();
}

echo "<a href='index.php'><< Início >></a>";

if (!empty($_GET['download_link'])) {
    $fileName = filter_var($_GET['download_link'], FILTER_SANITIZE_STRIPPED);
    $zipPHP->generateDownloadLink($fileName . ".zip");
}


if (!empty($_GET['filename']) && !empty($_GET['dirProjectName'])) {
    $filename = filter_var($_GET['filename'], FILTER_SANITIZE_STRIPPED);
    $dirProjectName = filter_var($_GET['dirProjectName'], FILTER_SANITIZE_STRIPPED);

    $zipPHP->zip($dirProjectName, $filename);
}


require_once __DIR__ . "/views/home.php";
