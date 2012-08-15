<?php

class Create_Pattern_Html {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('pattern_html', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// blob
			$table->blob('content');
			
			// int
			$table->integer('pattern_id');
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
		Schema::drop('pattern_html');
	}

}