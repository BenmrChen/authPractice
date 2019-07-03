<?php

namespace App\authPractice\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 資料表名稱
    protected $table = 'users';

    // 主鍵名稱
    protected $primaryKey = 'id';

    // 可大量指定異動column
    protected $fillable = [
        "user_name"
    ];

    // 建立與groups的多對多關聯
    public function groups()
    {
        return $this->belongsToMany('App\authPractice\Entity\Group')->withTimestamps();
    }
}
