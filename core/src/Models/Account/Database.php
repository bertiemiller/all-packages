<?php

namespace Topicmine\Core\Models\Account;

use DB;
use Schema;
use Artisan;
use App\Account;
use App\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Blueprint;

class Database extends Model
{
    protected $table = 'databases';

    protected $connection = 'mysql';

    protected $newAccountConnectionKey;

    public $fillable = [
        'host',
        'username',
        'password',
        'port',
        'database',
        'account_id',
        'connection_key',
        'name',
        'description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'database_id');
    }

    // Notes
    // http://laravel.io/forum/09-13-2014-create-new-database-and-tables-on-the-fly
    public function createDatabase($accountId)
    {
        // Setup user database server connection
        $this->serverConnectionKey = $this->setupServerConnectionKey($accountId);

        // create dynamic connection settings for new database
        $this->databaseSettings = $this->setupAndSaveNewAccountDatabaseSettings($accountId);
        $this->newAccountConnectionSettings = $this->getConnectionSettings($this->databaseSettings);

        // Create database and user
        $this->createNewDatabase();
        $this->createNewUser();

        // Run migrations and seeds
        $this->setupUserDatabaseServerConnection();
        $this->createUserDatabaseTables();

        return $this->databaseSettings->id;
    }

    public function setupServerConnectionKey($accountId)
    {
        // get server connection key name (static now but can extended to be dynamic)
        return $this->getUserDatabaseConnectionKey($accountId);
    }

    public function setupAndSaveNewAccountDatabaseSettings($accountId)
    {
        $newDatabaseInputs = $this->getNewAccountDatabaseSettings($accountId);
        $databaseSettings = $this->create( $newDatabaseInputs );

        // get account connection key name (static now but can extended to be dynamic) and save
        $account = new Account;
        $userAccount = $account->findOrFail($databaseSettings->account_id);
        $userAccount->fill(['database_id' => $databaseSettings->id]);
        $userAccount->save();

        return $databaseSettings;
    }

    public function createNewDatabase()
    {
        // create database
        $result = DB::connection($this->serverConnectionKey)
            ->statement('CREATE DATABASE ' . $this->newAccountConnectionSettings['database'] . ';' );

        if(true !== $result) {
            throw new GeneralException('Error creating new user database');
        }
    }

    public function createNewUser()
    {
        // create user
        $result = DB::connection($this->serverConnectionKey)
            ->statement('CREATE USER \'' . $this->newAccountConnectionSettings['username']  .
                '\'@\'localhost\' IDENTIFIED BY \'' .
                $this->newAccountConnectionSettings['password'].'\';');

        if(true !== $result) {
            throw new GeneralException('Error creating new user');
        }

        // % means all ips
        $result = DB::connection($this->serverConnectionKey)
            ->statement('GRANT ALL PRIVILEGES ON * . * TO \'' .
                $this->newAccountConnectionSettings['username'] . '\'@\'%\' IDENTIFIED BY \'secret\' WITH GRANT OPTION;');

        if(true !== $result) {
            throw new GeneralException('Error granting user privileges');
        }

        // flush privileges
        $result = DB::connection($this->serverConnectionKey)
            ->statement('FLUSH PRIVILEGES;');

        if(true !== $result) {
            throw new GeneralException('Error flushing privileges');
        }
    }

    public function setupUserDatabaseServerConnection()
    {
        // set connection for use. will need to set this for every request through a provider
        config(['database.connections.'.$this->databaseSettings->connection_key => $this->newAccountConnectionSettings]);

        // test the connection
        $newAccountConnection = DB::connection($this->databaseSettings->connection_key);
        // $newConnection is the MySqlConnection class

        if(! $newAccountConnection instanceof MySqlConnection) {
            throw new GeneralException('Cannot connect to new user database');
        }
    }

    public function createUserDatabaseTables()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        Schema::connection($this->databaseSettings->connection_key)->create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        // Would like to convert to an artisan command
        //        Artisan::call('migrate', [
        //            '--path' => 'database/migrations/user_database/2016_05_23_132326_create_domains_table.php',
        //        ]);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

    }

    public function getNewAccountDatabaseSettings($accountId)
    {
        return [
            'host' => $this->getHost($accountId),
            'port' => $this->getPort($accountId),
            'database' => $this->getDatabase($accountId).'_'.$accountId,
            'username' => 'topicmine'.$accountId,
            'password' => $this->getPassword($accountId),
            'account_id' => $accountId,
            'connection_key' => $this->getNewAccountDatabaseConnectionKey($accountId),
        ];
    }

    public function getUserDatabaseConnectionKey($accountId)
    {
        // this function will select which server to connect to
        // at the moment it is just the one
        return 'account_database';
    }

    public function getNewAccountDatabaseConnectionKey($accountId)
    {
        return 'user_database_'.$accountId;
    }

    public function getHost($accountId)
    {
        return env('DB_HOST_USER_DATABASE', '192.168.10.10');
    }

    public function getPort($accountId)
    {
        return env('DB_PORT_USER_DATABASE', '3306');
    }

    public function getDatabase($accountId)
    {
        return env('DB_DATABASE_USER_DATABASE', 'secret');
    }

    public function getUsername($accountId)
    {
        return env('DB_USERNAME_USER_DATABASE', 'topicmine');
    }

    public function getPassword($accountId)
    {
        return env('DB_PASSWORD_USER_DATABASE', 'secret');
    }

    public function getConnectionSettings($database)
    {
        return
            [
                'driver' => 'mysql',
                'host' => $database->host,
                'port' => $database->port,
                'database' => $database->database,
                'username' => $database->username,
                'password' => $database->password,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => 'tm_',
                'strict' => true,
                'engine' => null,
            ];
    }

    public function dropDatabaseAndUserIfExists($accountId)
    {
        $newAccountDatabaseSettings = $this->getNewAccountDatabaseSettings($accountId);

        // get connection key name (static now but can extended to be dynamic)
        $connectionKey = $this->getUserDatabaseConnectionKey($accountId);

        // drop database
        $result = DB::connection($connectionKey)
            ->statement('DROP DATABASE IF EXISTS ' . $newAccountDatabaseSettings['database'] . ';' );
        // $result === true

        if(true !== $result) {
            throw new GeneralException('Error dropping existing user database');
        }

        // drop database
        $result = DB::connection($connectionKey)
            ->statement('DROP USER IF EXISTS \'' . $newAccountDatabaseSettings['username']  .
                '\'@\'localhost\';' );
        // $result === true

        if(true !== $result) {
            throw new GeneralException('Error dropping existing user database');
        }
    }

}
