<?php

class Create_Pattern_Categories {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//create table
		Schema::create('pattern_categories', function($table) {
			
			// auto incremental id (PK)
			$table->increments('id');
			
			// varchar 32
			$table->string('name', 45);
			
			// int
			$table->integer('user_id');
			
			// boolean
			$table->boolean('active');
			
			// created_at | updated_at DATETIME
			$table->timestamps();
		});
		
		//insert data
		DB::table('pattern_categories')->insert(array(
			array(
				'name'  => 'Colors',
				),
			array(
				'name'  => 'Typography',
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
		Schema::drop('pattern_categories');
	}

}