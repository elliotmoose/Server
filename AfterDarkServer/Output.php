<?php

class Output
{
    public static function Success(String $detail)
    {
        $final = array();
        $final['success'] = "true";
        $final['detail'] = $detail;
        
        echo json_encode($final);
        die();
    }
    
    public static function SuccessWithArray(array $others)
    {
        $output = array();
        $output['success'] = "true";
        $output['detail'] = $others;
             
        
        echo json_encode($output);
    }
    
    public static function Fail(String $detail)
    {
        $final = array();
        $final['success'] = "false";
        $final['detail'] = $detail;
        
        echo json_encode($final);
        die();
    }
    
}