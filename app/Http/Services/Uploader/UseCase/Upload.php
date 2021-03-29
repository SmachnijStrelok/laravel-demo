<?php
namespace App\Http\Services\Uploader\UseCase;

use App\Helpers\DownloadHelper;
use App\Http\Components\IulByPdfGenerator\Repositories\UploadedFileInfoInterface;
use App\Http\Services\Uploader\Entities\File;
use App\Http\Services\Uploader\Entities\Progress;
use App\Http\Services\Uploader\FileUploader;
use App\Models\UploadedFileInfo;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Upload
{
    private $uploader;
    private $repository;

    public function __construct(
        FileUploader $uploader,
        UploadedFile $repository
    )
    {
        $this->uploader = $uploader;
        $this->repository = $repository;
    }

    /**
     * @param UploadedFile $file
     * @param int $createdAt
     * @return Progress|UploadedFileInfo
     * @internal param UploadedFile[] $files
     * @internal param array $modifiedDates
     */
    public function uploadFile(UploadedFile $file, \DateTimeImmutable $createdAt){
        $uploaderFile = $this->uploader->upload($file);
        if($uploaderFile instanceof File){
            $iulPdf = $this->repository->createByFile($uploaderFile);
            $iulPdf->user_id = Auth::user()->id;
            $iulPdf->created_at = $createdAt->format('Y-m-d H:i:s');

            return $this->repository->save($iulPdf);
        }else{
            return $uploaderFile;
        }
    }

    public function downloadFile(FilesystemAdapter $storage, int $fileId){
        $file = $this->repository->getById($fileId);
        if(!$file){
            throw new NotFoundHttpException('Файл не найден');
        }
        $fullPath = $storage->path($file->path);

        DownloadHelper::downloadFile($fullPath, $file->original_file_name);
    }

    // TODO по хорошему вынести в отдельный юз-кейс File(upload, download, change, delete)
    public function deleteFile(int $fileId)
    {
        $file = $this->repository->getById($fileId);
        if(!$file){
            throw new NotFoundHttpException('Файл не найден');
        }
        $this->repository->delete($file);
        $success = $this->uploader->remove($file->path);
        if(!$success){
            throw new \DomainException("Не удалось удалить файл {$file->original_file_name}");
        }
    }

}
