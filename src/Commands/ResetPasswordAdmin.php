<?php

namespace S4mpp\AdminPanel\Commands;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPasswordAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {email : E-mail user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if(!$user)
        {
            return $this->error('User not found!');
        }

        $password = app()->environment('local') ? '12345678' : Str::password();
        
        $user->password = Hash::make($password);
        
        $user->save();

        $this->info('Password changed successfully:');
        $this->info('E-mail: '.$email);
        $this->info('New password: '.$password);
    }
}
