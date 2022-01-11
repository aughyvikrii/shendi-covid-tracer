<?php

/**
 * Global function
 */

if(!function_exists('alert_warning')) {
    function alert_warning($message) {
        
    }
}

if(!function_exists('upload_file')) {
    function upload_file($name, $request) {
        try {
            $file = $request->file($name);
            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extenstion = $file->getClientOriginalExtension();
            $filenameSimpan = $file->hashName();
            $path = $file->move(public_path('files'), $filenameSimpan);

            return  $filenameSimpan;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return null;
        }
    }
}

if(!function_exists('_date_format')) {
    function _date_format($datetime, $format = 'l, d F Y H:i') {
        return \Carbon\Carbon::parse($datetime)->translatedFormat($format);
    }
}