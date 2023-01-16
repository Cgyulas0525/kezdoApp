<?php

namespace App\Classes;

class fileUploadClass
{

    public function fileUpload($file) {

        $file_extension = $file->extension();
        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $file_name . '.' .time() . '.' . $file_extension;
        $file->move(public_path('docs'), $fileName);

        return $fileName;
    }

}
