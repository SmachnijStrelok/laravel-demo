<?php

namespace App\Models;

use App\Http\Components\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\UploadedFileInfo
 *
 * @property integer $id
 * @property string $original_file_name
 * @property integer $user_id
 * @property integer $size
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo whereOriginalFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\BuildingObject|null $buildingObject
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedFileInfo whereSize($value)
 */
class UploadedFile extends Model
{
    public $isValid;
    public $validationErrors;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'uploaded_files';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'original_file_name',
        'size',
        'path',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function getSize(){
        return $this->size;
    }

    public function getOriginalName(){
        return $this->original_file_name;
    }

    public function getPath(){
        return $this->path;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid)
    {
        $this->isValid = $isValid;
    }

    public function addValidationError(string $error){
        $this->validationErrors[] = $error;
    }

    public function getValidationErrors(){
        return $this->getValidationErrors();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
