<?php

namespace App\authPractice\Entity;

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

    public function users()
    {
        return $this->belongsToMany('App\authPractice\Entity\User')->withTimestamps();
    }
}
