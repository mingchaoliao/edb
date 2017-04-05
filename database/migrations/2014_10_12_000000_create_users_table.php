<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

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
			$table->integer('role_id')->index()->unsigned()->nullable()->default(4);
			$table->unsignedTinyInteger('is_miami')->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

		User::create(['name' => 'Mingchao Liao', 'email' => 'liaom@miamioh.edu', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 1]);

		User::create(['name' => 'Administrator', 'email' => 'administrator@charlesliao.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 1]);
		User::create(['name' => 'Researcher', 'email' => 'researcher@charlesliao.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 2]);
		User::create(['name' => 'Contributor', 'email' => 'contributor@charlesliao.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 3]);
		User::create(['name' => 'Guest', 'email' => 'guest@charlesliao.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 4]);

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
