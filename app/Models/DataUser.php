<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataUser extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // 書き換え可能なフィールド
    protected $fillable = [
        'id',
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