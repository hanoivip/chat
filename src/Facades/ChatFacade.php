<?php

namespace Hanoivip\Chat\Facades;

use Illuminate\Support\Facades\Facade;

class ChatFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ChatService';
    }
}
