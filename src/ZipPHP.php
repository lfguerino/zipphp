<?php

namespace LFGuerino\ZipPHP;

class ZipPHP
{

    private $directory;

    public function zip(string $directory, string $outputZipFileName)
    {
        $this->directory = __DIR__ . "/../../" . $directory;
        // var_dump($directory, $this->directory);

        $files = $this->getDirItems(__DIR__ . "/../../" . $directory, true);

        $generated = $this->generate_zip_file(
            $files,
            __DIR__ . "/../output/{$outputZipFileName}.zip",
            false
        );

        if ($generated) {
            echo "<h1 style='color:blue'>Arquivo zip gerado com sucesso! ({$outputZipFileName})</h1>";
            echo "<h2>Fazer Download: <a href='?download={$outputZipFileName}'>{$outputZipFileName}.zip</a></h2>";
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
            $fileName = explode(basename($dir) . '/', $target)[0];
            if (!is_dir($target)) {
                $files[] = $fileName;
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
            die();
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                if (file_exists($file) && is_file($file)) {
                    $zip->addFile($file, str_replace(realpath($this->directory) . "\\", "", $file));
                }
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
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
}
