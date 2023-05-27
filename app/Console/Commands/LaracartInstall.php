<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LaracartInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracart:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will first generate the application encryption key, then it will run the migrations command, seed the database with dummy data, link the storage folder to public directory, and finally publish the ckeditor resources.';

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
        //Application encryption key.
        $this->call('key:generate');

        //Create tables.
        $this->call('migrate');

        /**
         *   ----Seed Database----
         * This command will generate dummy data
         * for products, cities, categories, and admins.
         */
        $this->call('db:seed');

        //callSilent() method will not show any error msgs.
        //Link the storage directory.
        $this->callSilent('storage:link');

        //publish resources for ckeditor.
        $this->call('vendor:publish',[
            '--tag' => 'ckeditor'
        ]);
    }
}
