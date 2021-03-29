<?php

namespace App\Http\Components\Settings\Entities;

use App\Http\Components\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $group_name
 * @property string $value_type
 * @property string $string_value
 * @property int $number_value
 * @property float $double_value
 * @property boolean $boolean_value
 * @property mixed $json_value
 * @property User $user
 * @property Setting $setting
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan query()
 * @mixin \Eloquent
 */
class ActualSetting extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'actual_settings';

    public $primaryKey = ['user_id', 'name'];

    public $timestamps = false;

    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class, 'name', 'name');
    }
}
