<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 資料表名稱
    protected $table = 'users';

    // 主鍵名稱
    protected $primaryKey = 'id';

    // 可大量指定異動column
    protected $fillable = [
        "user_name",
        "api_token",
    ];

    // 建立與 Group 的多對多關聯
    public function groups()
    {
        return $this->belongsToMany('App\Group')->withTimestamps();
    }

    // 建立與 Feature 的多對多關聯
    public function features()
    {
        return $this->belongsToMany('App\Feature')->withTimestamps();
    }
}
