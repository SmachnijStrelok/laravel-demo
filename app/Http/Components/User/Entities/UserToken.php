<?php

namespace App\Http\Components\User\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\UserToken
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property string $expires_in
 * @property string $refresh_token
 * @property string $ip
 * @property string $user_agent
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserToken whereUserId($value)
 * @mixin \Eloquent
 */
class UserToken extends Model
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
    protected $fillable = ['user_id', 'access_token', 'expires_in', 'refresh_token', 'ip', 'user_agent', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
