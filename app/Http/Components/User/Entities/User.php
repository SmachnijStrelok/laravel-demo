<?php

namespace App\Http\Components\User\Entities;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\User
 *
 * @property integer $id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property integer $mobile_phone
 * @property string $email
 * @property string $role
 * @property string $state
 * @property integer $capacity
 * @property string $password_hash
 * @property string $created_at
 * @property string $updated_at
 * @property UserConfirmation[] $userConfirmations
 * @property-read int|null $user_confirmations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereMobilePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    const STATE_UNCONFIRMED = 'unconfirmed';
    const STATE_ACTIVE = 'active';
    const STATE_BLOCKED = 'blocked';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['surname', 'name', 'patronymic', 'mobile_phone', 'email', 'role', 'state', 'capacity', 'password_hash', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userConfirmations()
    {
        return $this->hasMany(UserConfirmation::class);
    }


    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    public function isUser(): bool
    {
        return $this->role == self::ROLE_USER;
    }

    public function isAdmin(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }
}
