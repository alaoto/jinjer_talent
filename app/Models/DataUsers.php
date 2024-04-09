<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUsers extends Model
{
    use HasFactory;

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
        'address1',
        'tel',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
