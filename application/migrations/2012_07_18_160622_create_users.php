<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('users', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('username', 32);
			$table->string('email', 320);
			$table->string('password', 64);
			
			// boolean
			$table->boolean('active');
			
			// created_at | updated_at DATETIME
			$table->timestamps();
		});
		
		//insert admin
		DB::table('users')->insert(array(
			'username'  => 'admin',
			'email'  => 'richard.perry@teamdetroit.com',
			'password'  => Hash::make('password'),
			'active' => 1
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop table
		Schema::drop('users');
	}

}