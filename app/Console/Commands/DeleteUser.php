<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:deluser {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $validator = Validator::make(['email' => $this->argument('email')], [
            'email' => 'email',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors();

            $this->warn($errors);

            return;
        }

        $user = User::where('email', $this->argument('email'))->first();

        if ($user) {
            $user->delete();

            $this->info('User with email "' . $this->argument('email') . '" is deleted.');
        }
    }
}
