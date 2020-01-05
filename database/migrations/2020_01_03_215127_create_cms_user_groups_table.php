<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_user_groups', function (Blueprint $table) {
            $table->bigIncrements('access_id');
            $table->string('access_name');
            $table->boolean('access_user')->default(0);
            $table->boolean('access_userpasswords')->default(0);
            $table->boolean('access_useraccesslevel')->default(0);
            $table->boolean('access_accessgroups')->default(0);
            $table->boolean('access_cmssettings')->default(0);
            $table->boolean('access_settings')->default(0);
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
        Schema::dropIfExists('cms_user_groups');
    }
}
