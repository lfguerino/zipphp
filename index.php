<?php
require __DIR__ . "/vendor/autoload.php";

echo "<a href='index.php'><< Início >></a>";

$zipPHP = (new LFGuerino\ZipPHP\ZipPHP);

if (!empty($_GET['filename']) && !empty($_GET['dirProjectName'])) {
    $filename = filter_var($_GET['filename'], FILTER_SANITIZE_STRIPPED);
    $dirProjectName = filter_var($_GET['dirProjectName'], FILTER_SANITIZE_STRIPPED);

    $zipPHP->zip($dirProjectName, $filename);
}

if (!empty($_GET['download'])) {
    $file = __DIR__ . "/output/" . filter_var($_GET['download'], FILTER_SANITIZE_STRIPPED) . ".zip";

    if (file_exists($file)) {
        $content_type = mime_content_type($file);

        header('Content-Description: File Transfer');
        header("Content-Type: {$content_type}");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    } else {
        echo "<h1>Arquivo " . basename($file) . " não encontrado</h1>";
    }
}

require_once __DIR__ . "/views/home.php";
