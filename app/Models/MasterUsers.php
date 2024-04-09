<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MasterUsers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'master_users';
    protected $fillable = [
        'id',
        'user_name',
        'password',
        'last_login',
        'failure_start_datetime',
        'failure_cnt',
        'failure_stop_datatime',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // リレーションシップの定義
    public function userDetails()
    {
        return $this->hasOne(DataUsers::class, 'user_id');
    }
}
