<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAdmins extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_admins';
    protected $fillable = [
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
