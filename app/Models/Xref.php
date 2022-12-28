<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xref extends Model
{
    use HasFactory;

    // Indicates if the model should be timestamped
    public $timestamps = false;

    // The attributes that are mass assignable
    protected $fillable = [
        'type',
        'name',
        'component',
        'unit',
        'depthWhereUsed',
        'depthCalls',
        'includeSapObjects',
        'system',
        'release',
        'date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'includeSapObjects' => 'boolean',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }
}
