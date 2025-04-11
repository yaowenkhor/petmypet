<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'species',
        'breed',
        'age',
        'size',
        'location',
        'temperament',
        'medical_history',
        'status'
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
