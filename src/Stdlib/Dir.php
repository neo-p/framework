<?php

namespace Neop\Stdlib;

class Dir
{
    public static function setFile(string $filename, string $content)
    {
        $dir = dirname($filename);
        if (self::mkdirs($dir)) {
            file_put_contents($filename, $content);
        }
    }

    public static function getFileContent(string $filename): string
    {
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
        } else {
            throw new \Exception("File `" . $filename . "` is not exists");
        }
        return $content;
    }

    public static function deleteFile(string $filename): bool
    {
        if (file_exists($filename)) {
            $result = unlink($filename);
        } else {
            throw new \Exception("File `" . $filename . "` is not exists");
        }
        return $result;
    }

    public static function mkdirs(string $dir, int $mode = 0755): bool
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) 
            return TRUE;
        if (!self::mkdirs(dirname($dir), $mode)) 
            return FALSE;
        return @mkdir($dir, $mode);
    }

    public static function getExecPath()
    {
        return getcwd() . '/';
    } 

    public static function joinExecPath(string $path = '')
    {

        if (strpos('/', $path) !== 0) {
            $path = getcwd() . '/' . $path;
        }

        if (substr($path, -1) != '/') {
            $path =  $path . '/';
        }

        return $path;
    } 

    public static function joinExecFile(string $filename = '')
    {
        if (strpos('/', $filename) !== 0) {
            $filename = getcwd() . '/' . $filename;
        }

        return $filename;
    } 

    public static function pushFile(string $filename, string $content = '') 
    {
        $pushMode = 'a';
        $addMode = 'w';
        if (file_exists($filename)) {
            $file = fopen($filename, $pushMode);
            fwrite($file, $content);
            fclose($file);
        } else {
            $file = fopen($filename, $addMode);
            fwrite($file, $content);
            fclose($file);
        }
    }
}
