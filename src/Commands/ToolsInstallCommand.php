<?php

namespace ChuJC\Admin\Commands;

use Illuminate\Console\Command;

class ToolsInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:tools:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the admin tools';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->initDatabase();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        $this->call('migrate');

        $path = base_path('vendor/chujc/v-admin-tools/database/AdminToolDatabaseSeeder.php');
        require $path;

        $this->call('db:seed', ['--class' => \AdminToolDatabaseSeeder::class]);
    }
}
