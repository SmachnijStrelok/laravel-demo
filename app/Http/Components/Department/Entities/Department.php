<?php

namespace App\Http\Components\Department\Entities;

use App\Http\Components\User\Entities\User;
use App\Models\UploadedFile;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $logo_id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property UploadedFile $logo
 * @property User[] $users
 *
 * @mixin \Eloquent
 */
class Department extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['logo_id', 'name', 'description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function logo()
    {
        return $this->belongsTo(UploadedFile::class, 'logo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'department_to_users', 'department_id', 'user_id');
    }
}
