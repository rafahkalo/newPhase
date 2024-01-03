<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class generateUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:generate-users {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates test user data and insert into the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersData = $this->argument('count');
        for ($i = 0; $i < $usersData; $i++) {
            User::factory()->create();
        }
        $this->info('Insert successfully!');
    }
}
