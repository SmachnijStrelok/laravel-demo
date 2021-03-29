<?php

namespace App\Http\Components\User\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\UserConfirmation
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property string $type
 * @property string $code
 * @property string $sent_to
 * @property integer $attempt
 * @property bool   $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Components\User\Entities\UserConfirmation whereIsActive($value)
 * @mixin \Eloquent
 */
class UserConfirmation extends Model
{
    const ATTEMPT_MAX_COUNT = 3;

    const ACTION_SIGN_UP = 'signup';
    const ACTION_PASSWORD_RESET = 'password_reset';
    const ACTION_EMAIL_UPDATE = 'email_update';
    const ACTION_MOBILE_PHONE_UPDATE = 'mobile_phone_update';

    const TYPE_SMS = 'sms';
    const TYPE_EMAIL = 'email';
    const TYPE_VOICE = 'voice';

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user_confirmation';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'action', 'type', 'code', 'attempt', 'created_at', 'updated_at', 'is_active', 'sent_to'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createEmailUpdateConfirmation(int $userId, string $newEmail, string $activateCode)
    {
        $confirmation = new self();
        $confirmation->user_id = $userId;
        $confirmation->action = UserConfirmation::ACTION_EMAIL_UPDATE;
        $confirmation->type = $confirmation::TYPE_EMAIL;
        $confirmation->code = $activateCode;
        $confirmation->is_active = true;
        $confirmation->sent_to = $newEmail;
        return $confirmation;
    }

    public static function createMobilePhoneUpdateConfirmation(int $userId, string $newPhone, string $activateCode)
    {
        $confirmation = new self();
        $confirmation->user_id = $userId;
        $confirmation->action = UserConfirmation::ACTION_MOBILE_PHONE_UPDATE;
        $confirmation->type = $confirmation::TYPE_SMS;
        $confirmation->code = $activateCode;
        $confirmation->is_active = true;
        $confirmation->sent_to = $newPhone;
        return $confirmation;
    }
}
