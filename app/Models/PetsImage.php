<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetsImage extends Model
{
    use HasFactory;
    protected $table = 'pets_images';

    protected $fillable = [
        'pet_id',
        'image_path',
    ];
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

}
