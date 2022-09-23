<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'role_id',
        'name',
        'profile_pic',
        'email',
        'phone_number',
        'documents',
        'address',
        'status',
        'crated_at',
        'updated_at'
    ];
}
