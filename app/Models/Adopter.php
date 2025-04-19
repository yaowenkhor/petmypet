<?php

namespace App\Models;

<<<<<<< HEAD
use App\Models\AdoptionApplication;
=======
>>>>>>> 0cb742e297d9fd0edef004d0d8d8931cb06f2417
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function application()
    {
        return $this->hasMany(AdoptionApplication::class);
=======
    public function application(){
        return $this->hasMany(AdoptionApplication::class);  
>>>>>>> 0cb742e297d9fd0edef004d0d8d8931cb06f2417
    }

}


