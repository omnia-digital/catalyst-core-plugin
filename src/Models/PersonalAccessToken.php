<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $tokenable_type
 * @property string $name
 * @property string $token
 * @property string $abilities
 * @property int $last_used_at
 * @property int $created_at
 * @property int $updated_at
 */
class PersonalAccessToken extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personal_access_tokens';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tokenable_type' => 'string',
        'name' => 'string',
        'token' => 'string',
        'abilities' => 'string',
        'last_used_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    // Scopes...

    // Functions ...

    // Relations ...
}
