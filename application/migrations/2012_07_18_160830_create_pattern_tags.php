<?php

class Create_Pattern_Tags {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('pattern_tags', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('name', 45);
			
			// int
			$table->integer('pattern_id');
			
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
		Schema::drop('pattern_tags');
	}

}