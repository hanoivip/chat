<?php

namespace Hanoivip\Chat\ViewObjects;

class NewMessageVO
{
    public $senderId;
    public $senderName;
    public $count;
    
    public function __construct($senderId, $senderName, $count)
    {
        $this->senderId = $senderId;
        $this->senderName = $senderName;
        $this->count = $count;
    }
}