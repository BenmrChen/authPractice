<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_group', function (Blueprint $table) {
            $table->primary(['feature_id', 'group_id']);
            //這行可以讓user_id和group_id不會被重覆加進去
            $table->unsignedInteger('feature_id');
            $table->unsignedInteger('group_id');
            // foreign 要搭配 primary key，並指定(on)哪個表格的(references)哪個欄位
            // onDelete('cascade') 是為了避免資料刪除的時候，關聯資料表沒刪除到，所以建議要加上去
            $table->foreign('feature_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_group');
    }
}
