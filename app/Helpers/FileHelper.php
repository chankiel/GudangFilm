<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper{
    public static function cleanFileName($title){
        return preg_replace('/[^a-zA-Z0-9_-]/', '-', strtolower($title));   
    }

    public static function deleteFilmAsset($assetPath){
        if (Storage::disk('public')->delete($assetPath)) {
            return true;
        } else {
            return false;
        }
    }

    public static function formatDuration($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        $str = '';
        if ($hours > 0) {
            $str = $str . sprintf('%d Hour',$hours);
            if($hours>1){
                $str .= 's';
            }
        }
        if ($minutes > 0) {
            $str = $str . sprintf(' %02d Minute',$minutes);
            if($minutes>1){
                $str .= 's';
            }
        }
        if ($seconds > 0) {
            $str = $str . sprintf(' %02d Second',$seconds);
            if($seconds>1){
                $str .= 's';
            }
        }
        return $str;
    }
}