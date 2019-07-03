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
}
