<?php

class Create_Inspirations {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('inspirations', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// integer
			$table->integer('user_id');
			
			// varchar 32
			$table->string('name', 45);
			$table->string('description', 255);
			$table->string('image', 255);
			$table->string('url', 255);
			
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
		Schema::drop('inspirations');
	}

}