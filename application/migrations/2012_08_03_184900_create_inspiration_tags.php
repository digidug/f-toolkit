<?php

class Create_Inspiration_Tags {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('inspiration_tags', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// integer
			$table->integer('inspiration_id');
			$table->integer('tag_id');
			
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
		Schema::drop('inspiration_tags');
	}

}