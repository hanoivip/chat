<?php

namespace Hanoivip\Chat\Services;

use Hanoivip\Chat\Models\Message;
use Illuminate\Support\Facades\DB;
use Hanoivip\Chat\ViewObjects\NewMessageVO;
use Hanoivip\Chat\Events\MessageSent;

class ChatService {
    /**
     * Count new message by sender
     * 
     * @param number $userId
     * @return NewMessageVO[]
     */
    public function statNew($userId)
    {
        $records = Message::where('user_id', $userId)
        ->where('is_read', false)
        ->select('sender_id', 'sender_name', DB::raw('count(*) as total'))
        ->groupBy('sender_id')
        ->get();
        $vo = [];
        if ($records->isNotEmpty())
        {
            foreach ($records as $r)
            {
                $vo[] = new NewMessageVO($r->sender_id, $r->sender_name, $r->total);
            }
        }
        return $vo;
    }
    /**
     * Get all message sent by <sender>
     * 
     * @param number $userId
     * @param number $senderId
     * @param number $page
     * @return Message[]
     */
    public function getMessages($userId, $senderId, $page = 0)
    {
        $messages = Message::where('user_id', $userId)
        ->where('sender_id', $senderId)
        ->order('id', 'desc')
        ->skip(10 * $page)
        ->take(10)
        ->get();
        if ($messages->isNotEmpty())
            return $messages->toArray();
        else
            return [];
    }
    /**
     * Send a message to a user
     * 
     * @param number $senderId
     * @param number $receiverId
     * @param string $message
     * @return bool|string 
     */
    public function send($userId, $userName, $receiverId, $message)
    {
        $record = new Message();
        $record->user_id = $receiverId;
        $record->sender_id = $userId;
        $record->sender_name = $userName;
        $record->message = $message;
        $record->save();
        
        broadcast(new MessageSent($userId, $userName, $message))->toOthers();
        return true;
    }
    /**
     * Mark read all meessage from a user
     * @param number $senderId
     * @param number $receiverId
     * @return bool|string
     */
    public function markRead($senderId, $receiverId)
    {
        
    }
}
