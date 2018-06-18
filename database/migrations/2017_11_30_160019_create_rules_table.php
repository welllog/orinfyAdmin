<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64)->comment('权限菜单名称');
            $table->string('href', 64)->nullable()->comment('链接url');
            $table->string('rule', 64)->nullable()->comment('权限');
            $table->integer('pid')->default(0)->comment('父级id');
            $table->tinyInteger('check')->default(1)->comment('是否需要验证:0不需要,1需要');
            $table->tinyInteger('type')->default(1)->comment('类型:0仅权限,1菜单和权限');
            $table->tinyInteger('level')->default(1)->comment('菜单级数');
            $table->string('icon', 64)->nullable()->comment('图标');
            $table->smallInteger('sort')->default(50)->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
