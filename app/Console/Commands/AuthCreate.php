<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class AuthCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:create {id : ID user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание токена авторизации';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function formatter()
    {
        $whiteStyle = new OutputFormatterStyle('white', 'default');
        $greenStyle = new OutputFormatterStyle('green', 'default');
        $yellowStyle = new OutputFormatterStyle('yellow', 'default');
        $this->output->getFormatter()->setStyle('white', $whiteStyle);
        $this->output->getFormatter()->setStyle('yellow', $yellowStyle);
        $this->output->getFormatter()->setStyle('green', $greenStyle);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->formatter();
        $id_user = $this->argument('id');
        $user = User::find($id_user);
        $token = $user->createToken('User Token')->accessToken;

        $this->output->writeln($token);

        return 0;
    }
}
