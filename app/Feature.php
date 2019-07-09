<?php

namespace App\authPractice\Entity;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    // 資料表名稱
    protected $table = 'features';

    // 主鍵名稱
    protected $primaryKey = 'id';

    // 可大量指定異動column
    protected $fillable = [
        "feature_name",
    ];

//    建立與 Group 的多對多關聯
    public function groups()
    {
        return $this->belongsToMany('App\authPractice\Entity\Group')->withTimestamps();
    }

    // 建立與 User 的多對多關聯
    public function users()
    {
        return $this->belongsToMany('App\authPractice\Entity\User')->withTimestamps();
    }
}
