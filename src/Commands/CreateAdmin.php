<?php

namespace S4mpp\AdminPanel\Commands;


use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use S4mpp\Laraguard\Routes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--name= : Name User} {--email= : E-mail user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um usuário para o Painel Administrativo.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->name_user = ($name = $this->option('name')) ? $name : $this->_askName();
        
        $this->email_user = ($email = $this->option('email')) ? $email : $this->_askEmail();

        $this->password = $this->_getPassword();

        $user = new User();
        $user->name = $this->name_user;
        $user->email = $this->email_user;
        $user->password = Hash::make($this->password);
        
        $user->save();

        $this->info('Usuário criado com sucesso:');
        $this->info('Nome: '.$this->name_user);
        $this->info('E-mail: '.$this->email_user);
        $this->info('Senha: '.$this->password);
        $this->info('URL: '.route(Routes::login()));

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

    private function _askName()
    {
        $name = $this->ask('Informe o nome do usuário', 'Webmaster');

        try
        {
            if(!$name)
            {
                throw new Exception('O nome é obrigatório');
            }

            if(strlen($name) < 3)
            {
                throw new Exception('O nome deve ter pelo menos 3 caracteres');
            }

            return $name;
        }
        catch(Exception $e)
        {
            $this->error($e->getMessage());

            return $this->_askName();
        }
    }

    private function _askEmail()
    {
        if(!app()->environment('local'))
        {
            $email_default = 'webmaster@mail.com';
        }
        else
        {
            $email_default = Str::snake(Str::lower($this->name_user)).'@mail.com';
        }


        $email = $this->ask('Informe o e-mail do usuário '.$this->name_user, $email_default);

        try
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(!$email)
            {
                throw new Exception('O e-mail é obrigatório');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                throw new Exception('E-mail '.$email.' inválido');
            }
            
            if(User::where('email', $email)->first())
            {
                throw new Exception('E-mail '.$email.' já existe');
            }

            return $email;
        }
        catch(Exception $e)
        {
            $this->error($e->getMessage());

            return $this->_askEmail();
        }
    }
}
