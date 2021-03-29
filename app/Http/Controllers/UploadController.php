<?php
namespace App\Http\Controllers;

use App\Http\Services\Uploader\Entities\File;
use App\Http\Services\Uploader\FileUploader;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadController extends Controller
{

    /**
     * @param Request $request
     * @param FileUploader $uploader
     * @return File|\App\Http\Services\Uploader\Entities\Progress|UploadedFile
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException
     */
    public function upload(Request $request, FileUploader $uploader)
    {
        $file = $request->file('file');

        if(!$request->hasFile('file')){
            throw new NotFoundHttpException('no file');
        }

        $uploaderFile = $uploader->upload($file);
        if($uploaderFile instanceof File){
            $fileModel = new UploadedFile();
            $fileModel->original_file_name = $uploaderFile->getOriginalName();
            $fileModel->path = $uploaderFile->getPath();
            $fileModel->size = $uploaderFile->getSize();
            $fileModel->user_id = 1;//Auth::user()->id;
            $fileModel->created_at = date('Y-m-d H:i:s');

            $fileModel->save();
            return $fileModel;
        }else{
            return $uploaderFile;
        }
    }

    /**
     * @param Request $request
     * @param FileUploader $uploader
     * @throws \Exception
     */
    public function delete(Request $request, FileUploader $uploader)
    {
        $file = UploadedFile::findOrFail($request->input('id'));
        if(!$file){
            throw new NotFoundHttpException('Файл не найден');
        }
        $file->delete();
        $success = $uploader->remove($file->path);
        if(!$success){
            throw new \DomainException("Не удалось удалить файл {$file->original_file_name}");
        }
    }

}
