<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeTestDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdb:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Bolton test DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbname = config('database.connections.pgsql.database_test');
        $dbuser = config('database.connections.pgsql.username');
        $dbpass = config('database.connections.pgsql.password');
        $dbhost = config('database.connections.pgsql.host');
        try {
            $db = new \PDO("pgsql:host=$dbhost", $dbuser, $dbpass);
            $test = $db->exec("CREATE DATABASE $dbname");
            if($test === false) 
                throw new \Exception($db->errorInfo()[2]);
            $this->info(sprintf('Successfully created %s database', $dbname));
        }
        catch (\Exception $exception) {
            $this->error(sprintf('Failed to create %s database: %s', $dbname, $exception->getMessage()));
        }
    }
}
