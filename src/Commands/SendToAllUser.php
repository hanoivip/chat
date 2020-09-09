<?php

namespace Hanoivip\Chat\Commands;

use Illuminate\Console\Command;

class SendToAllUser extends Command
{
    protected $signature = 'admin:sendall {message}';
    
    protected $description = 'Admin send to a user a message';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {

    }
}
