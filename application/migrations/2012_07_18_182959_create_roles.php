<?php

class Create_Roles {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('roles', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('name', 32);
		});
		
		//insert admin
		DB::table('roles')->insert(array(
			array(
				'name'  => 'Administrator',
			),
			array(
				'name'  => 'Designer',
			),
			array(
				'name'  => 'Developer',
			),
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
		Schema::drop('roles');
	}

}