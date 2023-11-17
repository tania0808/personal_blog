<?php

namespace App\Core;

class ImageUpload
{
    public $image_name;
    private $image_type;
    private $image_size;
    private $image_temp;
    private $uploads_folder = __DIR__ . '/../../public/images/';
    private $upload_max_size = 2*24*1024;
    private $allowed_image_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

    public $error = '';

    /**
     * @param $image
     */

    // Class methods

    public function __construct($image){
        $this->image_name = time() . '_' . trim(basename($image['name']));
        $this->image_size = $image['size'];
        $this->image_type = $image['type'];
        $this->image_temp = $image['tmp_name'];

        $this->isImage();
        $this->imageNameValidation();
        $this->sizeValidation();
        $this->checkFile();
    }

    private function isImage(){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $this->image_temp);
        if(!in_array($mime, $this->allowed_image_types)){
            return $this->error = 'Only [ .jpeg, .jpg, .png and .gif ] files are allowed';
        }

        finfo_close($finfo);
    }

    private function imageNameValidation(){
        return $this->image_name = filter_var($this->image_name, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    private function sizeValidation(){
        if($this->image_size > $this->upload_max_size){
            return $this->error = 'File is bigger than 2MB';
        }
    }

    private function checkFile(){
        if(file_exists($this->uploads_folder.$this->image_name)){
            return $this->error = 'File already exists in folder';
        }
    }

    public function moveFile(){
        if(!move_uploaded_file($this->image_temp, $this->uploads_folder.$this->image_name)){
            return $this->error = 'There was an error, please try again';
        }
    }
}