<?php

namespace S4mpp\AdminPanel\Commands;


use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use S4mpp\Laraguard\Routes;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--name= : Name User} {--email= : E-mail user} {--role= : Assign Role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try
        {
            $this->name = $this->option('name');
            $this->email = $this->option('email');
            $this->role = $this->option('role');

            $this->email_user = $this->_getEmail();
            $this->name_user = $this->_getName();
            $this->role_user = $this->_getRole();
            
            $this->password = $this->_getPassword();
    
            $user = new User();
            $user->email = $this->email_user;
            $user->name = $this->name_user;
            $user->password = Hash::make($this->password);

            $user->save();
            
            if($this->role_user)
            {
                $user->assignRole($this->role_user);
            }
            
            $this->info('Admin created successfully:');
            $this->info('E-mail: '.$this->email_user);
            $this->info('Name: '.$this->name_user);
            $this->info('Password: '.$this->password);

            if($this->role_user)
            {
                $this->info('Role: '.$this->role_user->name);
            }

            $this->info('URL: '.route(Routes::login()));
        }
        catch(\Exception $e)
        {
            $this->error($e->getMessage());
        }

        return 0;
    }

    private function _getPassword()
    {
        if(app()->environment('local'))
        {
            return '12345678';
        }
        
        return Str::password();
    }

    private function _getRole()
    {
        if(!$this->role)
        {
            return null;
        }

        $role = Role::where('name', $this->role)->first();

        if(!$role)
        {
            throw new Exception('Role does not exist');
        }

        return $role;
    }


    private function _getName()
    {
        $name = ($name = $this->name) ? $name : $this->_generateName();

        if(!$name)
        {
            throw new Exception('The name is required');
        }

        if(strlen($name) <= 3)
        {
            throw new Exception('The name must have at least 3 characters');
        }

        return $name;
        
    }

    private function _getEmail()
    {        
        $email = ($email = $this->email) ? $email : $this->_getSuggestedEmail();

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if(!$email)
        {
            throw new Exception('The e-mail is required');
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception('E-mail '.$email.' invalid');
        }
        
        if(User::where('email', $email)->first())
        {
            throw new Exception('E-mail '.$email.' already exists');
        }

        return $email;
        
    }

    private function _getSuggestedEmail()
    {
        $email_test = $suggested_email = $this->name ?? 'webmaster';

        $attempts = 1;
        
        do
        {
            $email_existing = User::where('email', $email_test.'@mail.com')->first();

            if($email_existing)
            {
                $email_test = $suggested_email.$attempts;
                
                $attempts++;

                continue;
            }
            
            $suggested_email = $email_test;
        }
        while($email_existing);
        
        return $suggested_email.'@mail.com';
    }

    private function _generateName()
    {
        $email = explode('@', $this->email_user);

        return Str::title(Str::replace('-', ' ', Str::slug($email[0]))) ?? 'Webmaster';
    }
}
