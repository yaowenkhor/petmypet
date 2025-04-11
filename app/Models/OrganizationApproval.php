<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationApproval extends Model
{
    use HasFactory;

    protected $fillable =[
        'organization_id',
        'user_id',
        'status',
        'message',
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
