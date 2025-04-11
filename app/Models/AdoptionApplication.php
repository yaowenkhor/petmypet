<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'adopter_id',
        'pet_id',
        'organization_id',
        'question',
        'decision_message',
        'status',
    ];

    public function adopter()
    {
        return $this->belongsTo(Adopter::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
