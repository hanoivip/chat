<?php

namespace Hanoivip\Chat\Commands;

use Hanoivip\Chat\Services\ChatService;
use Illuminate\Console\Command;

class SendToUser extends Command
{
    protected $signature = 'admin:send {uid} {message}';
    
    protected $description = 'Admin send to a user a message';
    
    private $chat;
    
    public function __construct(ChatService $chat)
    {
        parent::__construct();
        $this->chat = $chat;
    }
    
    public function handle()
    {
        $uid = $this->argument('uid');
        $message = $this->argument('message');
        $this->chat->send(0, "System", $uid, $message);
    }
}
