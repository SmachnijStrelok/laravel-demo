<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $description
 * @property string $group_name
 * @property string $value_type
 * @property string $string_value
 * @property int $number_value
 * @property float $double_value
 * @property boolean $boolean_value
 * @property mixed $json_value
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadedIulScan query()
 * @mixin \Eloquent
 */
class Setting extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'group_name',
        'value_type',
        'string_value',
        'number_value',
        'double_value',
        'boolean_value',
        'json_value'
    ];

    public function getValue(){
        $propertyName = $this->value_type . '_value';
        return $this->$propertyName;
    }

    public function setValue($value){
        $propertyName = $this->value_type . '_value';
        $this->$propertyName = $value;
    }
}
