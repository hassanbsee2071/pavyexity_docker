<?php


namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;


class LogActivity
{
    public static function addToLog($log_data)
    {
    	LogActivityModel::create($log_data);
    }


    // public static function logActivityLists()
    // {
    // 	return LogActivityModel::latest()->get();
    // }
}
