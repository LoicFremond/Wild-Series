<?php

    namespace App\Service;
    use Symfony\Component\HttpFoundation\File\Exception\FileException;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    class FileUploader
    {
        private $targetDirectory;
        private $slugger;
        public function __construct($targetDirectory, Slugify $slugger)
        {
            $this->targetDirectory = $targetDirectory;
            $this->slugger = $slugger;
        }
        public function upload(UploadedFile $file)
        {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->generate($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            try {
                $file->move($this->getTargetDirectory(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                return null; // for example
            }
            return $fileName;
        }
        public function getTargetDirectory()
        {
            return $this->targetDirectory;
        }
    }