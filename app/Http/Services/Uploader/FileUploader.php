<?php
namespace App\Http\Services\Uploader;

use App\Http\Services\Uploader\Entities\File;
use App\Http\Services\Uploader\Entities\Progress;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Ramsey\Uuid\Uuid;

class FileUploader
{
    private FileSystemAdapter $storage;
    private Request $request;

    public function __construct(FilesystemAdapter $storage, Request $request)
    {
        $this->storage = $storage;
        $this->request = $request;
    }

    /**
     * @param UploadedFile $file
     * @param string|null $path
     * @return File|Progress
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */
    public function upload(UploadedFile $file, string $path = null)
    {
        $receiver = $this->getReceiver($file);
        $this->checkFileMissing($receiver);

        // необходимо перед $saver->receive(), после вызова местоположение файла изменится, получить данные не удастся
        $originalName = $file->getClientOriginalName();

        $save = $receiver->receive();
        if ($save->isFinished()) {
            $path = $path ?? date('Y/m/d');
            $path = $this->saveFile($save->getFile(), $path);
            $fileSize = $this->storage->size($path);
            $mimeType = $this->storage->mimeType($path);
            return new File($path, $fileSize, $originalName, $mimeType);
        } else {
            $handler = $save->handler();
            return new Progress($handler->getPercentageDone(), true);
        }
    }

    /**
     * @param UploadedFile $file
     * @return FileReceiver
     * @throws UploadFailedException
     */
    private function getReceiver(UploadedFile $file)
    {
        return new FileReceiver($file, $this->request, HandlerFactory::classFromRequest($this->request));
    }

    private function checkFileMissing(FileReceiver $receiver)
    {
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
    }

    private function saveFile(UploadedFile $file, string $path)
    {
        $fileName = $this->createFilename($file);
        $finalPath = $this->storage->path($path);
        $file->move($finalPath, $fileName);

        return $path . '/' . $fileName;
    }


    private function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Uuid::uuid4()->toString() . '.' . $extension;
        return $filename;
    }

    public function generateUrl(string $path): string
    {
        return asset($path);
    }

    public function remove(string $path)
    {
        if(!$this->storage->exists($path)){
            return true;
        }

        return $this->storage->delete($path);
    }
}
