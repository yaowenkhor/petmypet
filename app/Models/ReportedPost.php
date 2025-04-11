<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'adopter_id',
        'pet_id',
        'reason',
    ];

    public function adopter()
    {
        return $this->belongsTo(Adopter::class);
    }

    public function pet(){
        return $this->belongsTo(Pet::class);
    }

}
