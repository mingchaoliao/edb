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
            $table->unsignedTinyInteger('has_deleted')->default(0);

            $table->rememberToken();
            $table->timestamps();
        });

		User::create(['name' => 'Admin Don', 'email' => 'admin@fake.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 1]);
		User::create(['name' => 'Contributor Oops', 'email' => 'oops.con@fake.com', 'password' => '$2y$10$KIFP0HlI4HBUxHeew3wZr.Fm/w/nOLkQ6yuwuG1BnAqfsy2CnaHri', 'role_id' => 3]);

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
