<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2012 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Core;

/**
 * Migrate Class
 *
 * @package		Fuel
 * @category	Migrations
 * @link		http://docs.fuelphp.com/classes/migrate.html
 */
class Migrate
{
	/**
	 * @var	array	current migrations registered in the database
	 */
	protected static $migrations = array();

	/**
	 * @var	string	migration classes namespace prefix
	 */
	protected static $prefix = 'Fuel\\Migrations\\';

	/**
	 * @var	string	name of the migration table
	 */
	protected static $table = 'migration';

	/**
	 * @var	array	migration table schema
	 */
	protected static $table_definition = array(
		'type' => array('type' => 'varchar', 'constraint' => 25),
		'name' => array('type' => 'varchar', 'constraint' => 50),
		'migration' => array('type' => 'varchar', 'constraint' => 100, 'null' => false, 'default' => ''),
	);

	/**
	 * loads in the migrations config file, checks to see if the migrations
	 * table is set in the database (if not, create it), and reads in all of
	 * the versions from the DB.
	 *
	 * @return  void
	 */
	public static function _init()
	{
		logger(\Fuel::L_DEBUG, 'Migrate class initialized');

		// load the migrations config
		\Config::load('migrations', true);

		// set the name of the table containing the installed migrations
		static::$table = \Config::get('migrations.table', static::$table);

		// installs or upgrades the migration table to the current schema
		static::table_version_check();

		//get all installed migrations from db
		$migrations = \DB::select()
			->from(static::$table)
			->order_by('type', 'ASC')
			->order_by('name', 'ASC')
			->order_by('migration', 'ASC')
			->execute()
			->as_array();

		// convert the db migrations to match the config file structure
		foreach($migrations as $migration)
		{
			isset(static::$migrations[$migration['type']]) or static::$migrations[$migration['type']] = array();
			static::$migrations[$migration['type']][$migration['name']][] = $migration['migration'];
		}
	}

	/**
	 * migrate to a specific version or range of versions
	 *
	 * @param   mixed	version to migrate to (up or down!)
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 *
	 * @throws	UnexpectedValueException
	 * @return	array
	 */
	public static function version($version = null, $name = 'default', $type = 'app')
	{
		// get the current version from the config
		$current = \Config::get('migrations.version.'.$type.'.'.$name);

		// any migrations defined?
		if ( ! empty($current))
		{
			// get the timestamp of the last installed migration
			if (preg_match('/^(.*?)_(.*)$/', end($current), $match))
			{
				// determine the direction
				$direction = (is_null($version) or $match[1] < $version) ? 'up' : 'down';

				// fetch the migrations
				if ($direction == 'up')
				{
					$migrations = static::find_migrations($name, $type, $match[1], $version);
				}
				else
				{
					$migrations = static::find_migrations($name, $type, $version, $match[1], $direction);

					// we're going down, so reverse the order of mygrations
					$migrations = array_reverse($migrations, true);
				}

				// run migrations from current version to given version
				return static::run($migrations, $name, $type, $direction);
			}
			else
			{
				throw new \UnexpectedValueException('Could not determine a valid version from '.$current.'.');
			}
		}

		// run migrations from the beginning to given version
		return static::run(static::find_migrations($name, $type, null, $version), $name, $type, 'up');
	}

	/**
	 * migrate to a latest version
	 *
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 *
	 * @return	array
	 */
	public static function latest($name = 'default', $type = 'app')
	{
		// equivalent to from current version to latest
		return static::version(null, $name, $type);
	}

	/**
	 * migrate to the version defined in the config file
	 *
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 *
	 * @return	array
	 */
	public static function current($name = 'default', $type = 'app')
	{
		// get the current version from the config
		$current = \Config::get('migrations.version.'.$type.'.'.$name);

		// any migrations defined?
		if ( ! empty($current))
		{
			// get the timestamp of the last installed migration
			if (preg_match('/^(.*?)_(.*)$/', end($current), $match))
			{
				// run migrations from start to current version
				return static::run(static::find_migrations($name, $type, null, $match[1]), $name, $type, 'up');
			}
		}

		// nothing to migrate
		return array();
	}

	/**
	 * migrate up to the next version
	 *
	 * @param   mixed	version to migrate up to
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 *
	 * @return	array
	 */
	public static function up($version = null, $name = 'default', $type = 'app')
	{
		// get the current version info from the config
		$current = \Config::get('migrations.version.'.$type.'.'.$name);

		// any migrations defined?
		if ( ! empty($current))
		{
			// get the last entry
			$current = end($current);

			// get the available migrations after the current one
			$migrations = static::find_migrations($name, $type, $current, $version);

			// found any?
			if ( ! empty($migrations))
			{
				// if no version was given, only install the next migration
				is_null($version) and $migrations = array(reset($migrations));

				// install migrations found
				return static::run($migrations, $name, $type, 'up');
			}
		}

		// nothing to migrate
		return array();
	}

	/**
	 * migrate down to the previous version
	 *
	 * @param   mixed	version to migrate down to
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 *
	 * @return	array
	 */
	public static function down($version = null, $name = 'default', $type = 'app')
	{
		// get the current version info from the config
		$current = \Config::get('migrations.version.'.$type.'.'.$name);

		// any migrations defined?
		if ( ! empty($current))
		{
			// get the last entry
			$current = end($current);

			// get the available migrations before the last current one
			$migrations = static::find_migrations($name, $type, $version, $current, 'down');

			// found any?
			if ( ! empty($migrations))
			{
				// we're going down, so reverse the order of mygrations
				$migrations = array_reverse($migrations, true);

				// if no version was given, only revert the last migration
				is_null($version) and $migrations = array(reset($migrations));

				// revert the installed migrations
				return static::run($migrations, $name, $type, 'down');
			}
		}

		// nothing to migrate
		return array();
	}

	/**
	 * run the action migrations found
	 *
	 * @param   array	list of files to migrate
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 * @param   string  method to call on the migration
	 *
	 * @return	array
	 */
	protected static function run($migrations, $name, $type, $method = 'up')
	{
		// storage for installed migrations
		$done = array();

		// Loop through the runnable migrations and run them
		foreach ($migrations as $ver => $migration)
		{
			logger(Fuel::L_INFO, 'Migrating to version: '.$ver);
			call_user_func(array(new $migration['class'], $method));
			$file = basename($migration['path'], '.php');
			$method == 'up' ? static::write_install($name, $type, $file) : static::write_revert($name, $type, $file);
			$done[] = $file;
		}

		empty($done) or logger(Fuel::L_INFO, 'Migrated to '.$ver.' successfully.');

		return $done;
	}


	/**
	 * add an installed migration to the database
	 *
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 * @param   string  name of the migration file just run
	 *
	 * @return	void
	 */
	protected static function write_install($name, $type, $file)
	{
		// add the migration just run
		\DB::insert(static::$table)->set(array(
			'name' => $name,
			'type' => $type,
			'migration' => $file,
		))->execute();

		// add the file to the list of run migrations
		static::$migrations[$type][$name][] = $file;

		// make sure the migrations are in the correct order
		sort(static::$migrations[$type][$name]);

		// and save the update to the environment config file
		\Config::set('migrations.version.'.$type.'.'.$name, static::$migrations[$type][$name]);
		\Config::save(\Fuel::$env.DS.'migrations', 'migrations');
	}

	/**
	 * remove a reverted migration from the database
	 *
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 * @param   string  name of the migration file just run
	 *
	 * @return	void
	 */
	protected static function write_revert($name, $type, $file)
	{
		// remove the migration just run
		\DB::delete(static::$table)
			->where('name', $name)
			->where('type', $type)
			->where('migration', $file)
		->execute();

		// remove the file from the list of run migrations
		if (($key = array_search($file, static::$migrations[$type][$name])) !== false)
		{
			unset(static::$migrations[$type][$name][$key]);
		}

		// make sure the migrations are in the correct order
		sort(static::$migrations[$type][$name]);

		// and save the update to the config file
		\Config::set('migrations.version.'.$type.'.'.$name, static::$migrations[$type][$name]);
		\Config::save(\Fuel::$env.DS.'migrations', 'migrations');
	}

	/**
	 * migrate down to the previous version
	 *
	 * @param   string  name of the package, module or app
	 * @param   string  type of migration (package, module or app)
	 * @param	mixed	version to start migrations from, or null to start at the beginning
	 * @param	mixed	version to end migrations by, or null to migrate to the end
	 *
	 * @return	array
	 */
	protected stat