<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // 資料表名稱
    protected $table = 'groups';

    // 主鍵名稱
    protected $primaryKey = 'id';

    // 可大量指定異動column
    protected $fillable = [
        "group_name",
    ];

    // 建立與 User 的多對多關聯
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    // 建立與 Feature 的多對多關聯
    public function features()
    {
        return $this->belongsToMany('App\Feature')->withTimestamps();
    }
}
