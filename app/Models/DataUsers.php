<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataUsers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_users';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'birthday',
        'nickname',
        'zipcode',
        'prefcode',
        'city',
        'address',
        'tel',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
    ];
}
