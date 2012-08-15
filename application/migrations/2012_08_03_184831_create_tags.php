<?php

class Create_Tags {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('tags', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('name', 45);
			
			// created_at | updated_at DATETIME
			$table->timestamps();
		});
		
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//drop table
		Schema::drop('tags');
	}

}