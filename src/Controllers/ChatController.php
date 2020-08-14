<?php
namespace Hanoivip\Chat\Controllers;

use Illuminate\Http\Request;
use Hanoivip\Chat\Models\Message;
use Hanoivip\Chat\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use Hanoivip\Chat\Services\ChatService;
use Hanoivip\Chat\Services\ViewObjectService;

class ChatController extends Controller
{
    protected $service;
    
    protected $mapper;

    public function __construct(
        ChatService $service,
        ViewObjectService $mapper)
    {
        $this->service = $service;
        $this->mapper = $mapper;
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hanoivip::chat');
    }
    /**
     * Statistic new messages
     * 
     * @param Request $request
     */
    public function statNew(Request $request)
    {
        try {
            $userId = Auth::user()->getAuthIdentifier();
            $stat = $this->service->statNew($userId);
            return ['error' => 0, 'data' => ['stat' => $stat]];
        }
        catch (Exception $ex) {
            Log::error('Chat stat new message exception: ' . $ex->getMessage());
            return ['error' => 2, 'data' => []];
        }
    }
    /**
     * Fetch messages
     *
     * @return Message
     */
    public function fetchMessages(Request $request)
    {
        try {
            $userId = Auth::user()->getAuthIdentifier();
            $sender = $request->input('sender');
            $page = 0;
            if ($request->has('page'))
                $page = $request->input('page');
            $messages = $this->service->getMessages($userId, $sender, $page);
            return ['error' => 0, 'data' => ['messages' => $messages, 'read' => 0]];
        }
        catch (Exception $ex) {
            Log::error('Chat fetch message exception: ' . $ex->getMessage());
            return ['error' => 2, 'data' => []];
        }
    }

    /**
     * Persist message to database
     *
     * @param Request $request
     */
    public function sendMessage(Request $request)
    {
        try {
            $userId = Auth::user()->getAuthIdentifier();
            $userName = Auth::user()->getAuthIdentifierName();
            $receiverId = $request->get('receiver');
            $message = $request->get('message');
            $result = $this->service->send($userId, $userName, $receiverId, $message);
            if ($result === true)
                return ['error' => 0, 'message' => __('hanoivip::chat.send.success'), 'data' => []];
            else 
                return ['error' => 1, 'message' => $result, 'data' => []];
        } catch (Exception $ex) {
            Log::error('Chat send message exception: ' . $ex->getMessage());
            return ['error' => 2, 'message' => __('hanoivip::chat.send.exception'), 'data' => []];
        }
    }

    public function markRead(Request $request)
    {
        try {
            $senderId = $request->get('sender');
            $userId = Auth::user()->getAuthIdentifier();
            $result = $this->service->markRead($userId, $senderId);
            if ($result === true)
                return ['error' => 0, 'message' => __('hanoivip::chat.read.success'), 'data' => []];
            else
                return ['error' => 1, 'message' => $result, 'data' => []];
        }
        catch (Exception $ex) {
            Log::error('Chat mark read message exception: ' . $ex->getMessage());
            return ['error' => 2, 'message' => __('hanoivip::chat.read.exception'), 'data' => []];
        }
    }
}
