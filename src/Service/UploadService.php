<?php
declare(strict_types=1);
namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadService
{
    private string $targetDirectoryLogo;
    private SluggerInterface $slugger;

    public function __construct($targetDirectoryLogo, SluggerInterface $slugger)
    {
        $this->targetDirectoryLogo = $targetDirectoryLogo;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, $class): mixed
    {
        if ($class instanceof User) {

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();

            try {
                $file->move($this->getTargetDirectoryLogo(), $fileName);
                $class->setLogo($fileName);
            } catch (FileException $exception) {
                return null;
            }
        }
        return $class;
    }

    public function getTargetDirectoryLogo(): string
    {
        return $this->targetDirectoryLogo;
    }
}