<?php

namespace App\Core;

class ImageUpload
{
    public string $image_name;
    private string $image_type;
    private int $image_size;
    private string $image_temp;
    public string $uploads_folder = __DIR__ . '/../../public/images/';
    private int $upload_max_size = 2097152;
    private array $allowed_image_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

    private array $errors = [];

    public function getImageName(): string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): void
    {
        $this->image_name = $image_name;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @param $image
     */

    public function __construct($image)
    {
        $this->image_name = time() . '_' . trim(basename($image['name']));
        $this->image_size = $image['size'];
        $this->image_type = $image['type'];
        $this->image_temp = $image['tmp_name'];

        $this->isImage();
        $this->imageNameValidation();
        $this->sizeValidation();
        $this->checkFile();
    }

    private function isImage(): void
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mime = finfo_file($finfo, $this->image_temp);
        if (!in_array($mime, $this->allowed_image_types)) {
            $this->setError('Only [ .jpeg, .jpg, .png, .webp and .gif ] files are allowed');
        }

        finfo_close($finfo);
    }

    private function imageNameValidation(): void
    {
        $this->setImageName(filter_var($this->image_name, FILTER_SANITIZE_SPECIAL_CHARS));
    }

    private function sizeValidation(): void
    {
        if ($this->image_size > $this->upload_max_size) {
            $this->setError('File is bigger than 2MB');
        }
    }

    private function checkFile(): void
    {
        if (file_exists($this->uploads_folder.$this->image_name)) {
            $this->setError('File already exists in folder');
        }
    }

    public function moveFile(): void
    {
        if (!move_uploaded_file($this->image_temp, $this->uploads_folder.$this->image_name)) {
            $this->setError('There was an error, please try again');
        }
    }
}
