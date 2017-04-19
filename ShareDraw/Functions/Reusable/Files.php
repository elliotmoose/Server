<?php

require_once (__DIR__.'/Output.php');

class Files
{
    public static function ReadJSONFile(String $dir) {
        if ($file = fopen($dir, 'r+')) {
            $fileContents = json_decode(fread($file, filesize($dir)),true);
            
            return $fileContents;
        }
        else
        {
            Output::Fail("Invalid Subscription: This group is not initialized");
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
    
    

}