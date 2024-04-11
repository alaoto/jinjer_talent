<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAdmin extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // 書き換え可能なフィールド
    protected $fillable = [
        'id',
        'admin_id',
        'permission_code',
        'first_name',
        'last_name',
        'email',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}