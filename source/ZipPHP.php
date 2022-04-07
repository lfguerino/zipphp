<?php

namespace LFGuerino\ZipPHP;

class ZipPHP
{

    private $directory;

    public function home(): void
    {
        echo "<h1>Home</h1>";
    }

    public function zip(string $directory, string $outputZipFile)
    {

        $outputZipFile = __DIR__ . "/../output/{$outputZipFile}.zip";
        $fileOutputName = basename($outputZipFile);

        if (file_exists($outputZipFile)) {
            echo ("<h1 style='color:red'>Ops! O arquivo {$fileOutputName} já existe!<h1>");
            $this->generateDownloadLink($fileOutputName);
            return;
        }

        $this->directory = __DIR__ . "/../../" . $directory;

        if (!is_dir($this->directory)) {
            echo ("<h1 style='color:red'>O diretório desejado não foi econtrado!<h1>");
            return;
        }

        $files = $this->getDirItems(__DIR__ . "/../../" . $directory, true);

        $generated = $this->generate_zip_file(
            $files,
            __DIR__ . "/../output/{$fileOutputName}",
            false
        );

        if ($generated) {
            echo "<h1 style='color:blue'>Arquivo zip gerado com sucesso! ({$fileOutputName})</h1>";
            $this->generateDownloadLink($fileOutputName);
        } else {
            echo "<h1 style='color:red'>Ops! Ocorreu um erro ao gerar o arquivo zip!</h1>";
        }
    }


    public function auth(): bool
    {
        $_require_password     = false;
        $_password             = '';

        if ($_require_password) {
            $zipcf_pass = htmlspecialchars($_REQUEST['password']);
            if (empty($zipcf_pass) || $zipcf_pass != $_password) {
                return false;
            }
        }
        return true;
    }

    function getDirItems($dir, $recursive = false, &$files = array())
    {
        $scan = scandir($dir);
        foreach ($scan as $key => $value) {
            $target = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($target)) {
                $files[] = $target;
            } else if ($value != "." && $value != "..") {
                if ($recursive) {
                    $this->getDirItems($target, true, $files);
                }
            }
        }
        return $files;
    }

    /* creates a compressed zip file */
    function generate_zip_file($files = array(), $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            $fileName = basename($destination);
            echo ("<h1 style='color:red'>Ops! O arquivo {$fileName} já existe!<h1>");
            echo "<h2>Fazer Download: <a href='?download={$fileName}'>{$fileName}</a></h2>";
            return false;
        }
        //vars
        $valid_files = array();
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }

        if (count($valid_files)) {
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            foreach ($valid_files as $file) {
                if (file_exists($file) && is_file($file)) {
                    $zip->addFile($file, str_replace(realpath($this->directory) . "\\", "", $file));
                }
            }

            $zip->close();

            return file_exists($destination);
        } else {
            return false;
        }
    }

    public function download($file)
    {

        $content_type = mime_content_type($file);

        header('Content-Description: File Transfer');
        header("Content-Type: {$content_type}");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }

    public function generateDownloadLink(string $fileOutputName): void
    {
        $filePath = __DIR__ . "/../output/{$fileOutputName}";

        if (file_exists($filePath)) {
            echo "<h1 style='color: green'>Link para Download: <a href='output/{$fileOutputName}'>{$fileOutputName}</a></h1>";
        } else {
            echo "<h1 style='color: red'> O arquivo {$fileOutputName} não existe!</h1>";
        }
    }
}
