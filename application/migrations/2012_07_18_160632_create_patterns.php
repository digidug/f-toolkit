<?php

class Create_Patterns {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('patterns', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('name', 45);
			
			// int
			$table->integer('pattern_category_id');
			$table->integer('user_id');
			
			// boolean
			$table->boolean('active');
			
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
		Schema::drop('patterns');
	}

}