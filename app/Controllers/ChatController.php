<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\BiddingModel;
use App\Models\ChatModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Razorpay\Api\Product;

class ChatController extends BaseController
{ 
    protected ChatModel $chatModel;
    protected BiddingModel $biddingModel;

    protected const MESSAGES_LIMIT = 100;
    protected const CHATS_LIMIT    = 50;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        if (!authCheck()) {
            redirectToUrl(langBaseUrl());
        }

        $this->chatModel    = new ChatModel;
        $this->biddingModel = new BiddingModel;
    }

    public function initChat()
    {
        $product = $this->productModel->getActiveProduct( inputPost('product') );
        $chat   = $this->chatModel->initOrGetChat( $product );
        return redirect()->to("messages/{$chat['uuid']}");
    }

    public function chat( string $uuid )
    {
        $data['title']          = trans("messages");
        $data['description']    = trans("messages") . ' - ' . $this->baseVars->appName;
        $data['keywords']       = trans("messages") . ',' . $this->baseVars->appName;
        $data['chat']           = $this->chatModel->where('uuid',$uuid)->first();
        
        if ( empty( $data['chat'] ) ) {
            return redirect()->to('messages');
        }

        $data['chats']          = $this->chatModel->getChats(user()->id,self::CHATS_LIMIT);
        $data['messages']       = $this->chatModel->getMessages( $data['chat']['id'],self::MESSAGES_LIMIT );
        $data['sender']         = getUser($data['chat']['sender_id']);
        $data['receiver']       = getUser($data['chat']['receiver_id']);
        $data['product']        = getProduct($data['chat']['product_id']);
        $data['biddingModel']   = $this->biddingModel;

        echo view('partials/_header', $data);
        echo view('chat/chat', $data);
        echo view('partials/_footer');
    }

    public function chats()
    {
        $data['title']          = trans("messages");
        $data['description']    = trans("messages") . ' - ' . $this->baseVars->appName;
        $data['keywords']       = trans("messages") . ',' . $this->baseVars->appName;
        $data['chats']          = $this->chatModel->getChats(user()->id,self::CHATS_LIMIT);

        echo view('partials/_header', $data);
        echo view('chat/chat', $data);
        echo view('partials/_footer');
    }

    public function getChats()
    {
        return json_encode( $this->chatModel->getChatsArray(
            chatId:inputGet('chat_id')
        ));
    }

    public function getMessages()
    {
        $chat     = $this->chatModel->getChat(inputGet('chat_id'));

        if ( $chat ) {
            $product                = getActiveProduct($chat->product_id);
            $product->price_html    = priceFormatted($product->price,$product->currency,true);
            $chat->product          = $product;
        }

        $messages = $this->chatModel->getMessagesArray(
            chatId:inputGet('chat_id'),
            limit:100
        );
        
        $messages = array_reverse( $messages );
        return json_encode(compact('chat','messages'));
    }
}
