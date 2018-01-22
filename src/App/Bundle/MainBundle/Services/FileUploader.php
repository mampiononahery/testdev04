<?php

namespace App\Bundle\MainBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FIleUploader
 * @author  Fehiniaina Raharinivoson <fehiniaina28@gmail.com>
 * @package App\Bundle\MainBundle\Services
 */
class FileUploader
{
    /**
     * @var $targetDir
     */
    private $targetDir ;

    /**
     * FIleUploader constructor.
     * 
     * @param $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param mixed $targetDir
     */
    public function setTargetDir($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * Upload file.
     *
     * @param UploadedFile $file
     *
     * @return string File Name
     */
    public function upload (UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        if (!is_dir($this->targetDir)) {
            mkdir($this->targetDir, 0755, true) ;
        }

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }
}