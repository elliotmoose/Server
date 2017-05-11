<?php

require_once (__DIR__.'/Output.php');

class Files
{
    public static function ReadJSONFile(String $dir) {
        if ($file = fopen($dir, 'r+')) {
            $fileContents = json_decode(fread($file, filesize($dir)),true);
            fclose($file);
            return $fileContents;
        }
        else
        {
            Output::Fail("Group or File does not exist: $dir");
        }
    }
    public static function OverrideFile(string $dir, string $contents)
    {
        if ($file = fopen($dir, 'w+')) {
            fwrite($file,$contents);
            fclose($file);
        }
        else
        {
            Output::Fail("Group or File does not exist: $dir");
        }
    }
    public static function GetAllDirNames(String $dir)
    {
        $iterator = new DirectoryIterator($dir);

        $outputArray = [];
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir() && !$fileInfo->isDot()) {
                $fileName = $fileInfo->getFilename();
                array_push($outputArray, $fileName);
            }
        }
        
        return $outputArray;
    }
    
    function rrmdir($src)
{
    $dir = opendir($src);
    while(false!== ($file = readdir($dir)))
    {
        if(($file != '.') && ($file != '..'))
        {
            $full = $src . '/' . $file;
            if(is_dir($full))
            {
                rrmdir($full);
            }
            else
            {
                unlink($full);
            }
        }
    }
    
    closedir($dir);
    if(rmdir($src))
    {
        return true;        
    }
    else
    {
        return false;
    }
}

}