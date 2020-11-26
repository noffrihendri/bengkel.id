<?php

namespace App\Libraries;
class imageloader
{

    public function uploadfile($file){
        
        // $validated = $this->validate([
        //     'file_upload' => 'uploaded[file_upload]|mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png]|max_size[file_upload,4096]'
        // ]);

      //  dd($file);

        $name = $file->getName(); // Mengetahui Nama File
        $originalName = $file->getClientName(); // Mengetahui Nama Asli
        $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
        $ext = $file->getClientExtension(); // Mengetahui extensi File
        $type = $file->getClientMimeType(); // Mengetahui Mime File
        $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
        $size_mb = $file->getSize('mb');// Mengetahui Ukuran File dalam mb
        $namabaru = $file->getRandomName(); //define nama fiel yang baru secara acak

        $arrresult = array();

        if ($type == (('image/png') or ('image/jpeg'))) //cek mime file
        {    // File Tipe Sesuai
            $image = \Config\Services::image('gd'); //Load Image Libray
            $info = $image->withFile($file)->getFile()->getProperties(true); //Mendapatkan Files Propertis
            $width = $info['width']; // Mengetahui Image Width
            $height = $info['height']; // Mengetahui Image Height

            $path = "public/images";
            $direktori = ROOTPATH . $path; //definisikan direktori upload
        

        
            if ($file->move($direktori, $namabaru)) {
                 $arrresult = array(
                    "valid" => true,
                    "message" => "berhasil diupload",
                    "name" => $namabaru,
                    "path" => $path.'/'.$namabaru
                );
            } else {

                 $arrresult = array(
                    "valid" => false,
                    "message" => "gagal diupload"
                );
            }
        } else {
             $arrresult = array(
                "valid" => false,
                "message" => "berhasil diupload"
            );
        }

        return $arrresult;
    }
}
