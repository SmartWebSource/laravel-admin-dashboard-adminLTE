<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email',50)->unique();
            $table->string('phone',20)->unique();
            $table->string('username',16)->unique();
            $table->string('password');
            $table->string('role',20);
            $table->boolean('active')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->ipAddress('last_login_ip',50)->nullable();
            $table->string('photo',250)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
