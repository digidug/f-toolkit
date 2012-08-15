<?php

class Create_Role_User {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('role_user', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// integer
			$table->integer('user_id');
			$table->integer('role_id');
			
			// created_at | updated_at DATETIME
			$table->timestamps();
		});
		
		//insert admin
		DB::table('role_user')->insert(array(
			'user_id'  => 1,
			'role_id'  => 1
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
		Schema::drop('role_user');
	}

}