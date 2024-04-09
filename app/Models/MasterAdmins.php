<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MasterAdmins extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'master_admins';
    protected $fillable = [
        'id',
        'admin_name',
        'password',
        'last_login',
        'failure_start_datetime',
        'failure_cnt',
        'failure_stop_datatime',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // リレーションシップの定義
    public function adminDetails()
    {
        return $this->hasOne(DataAdmin::class, 'admin_id');
    }
}
