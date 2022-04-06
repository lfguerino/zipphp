<?php
require __DIR__ . "/vendor/autoload.php";

$zipPHP = (new LFGuerino\ZipPHP\ZipPHP);

if (empty($_GET['download'])) {
    $zipPHP->zip("agendaweb", "meuProjeto");
} else {
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
