<?php namespace App\Models;

class ChatModel extends BaseModel
{
    protected $builder;
    protected $builderMessages;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('chat');
        $this->builderMessages = $this->db->table('chat_messages');
    }

    public function initOrGetChat( $product )
    {
        $seller    = (new AuthModel)->getUser($product->user_id);

        if ( ! ( $chat = $this->builder->where('sender_id',user()->id)->where('receiver_id',$seller->id)->where('product_id',$product->id)->get()->getRow(type:'array') ) ) {

            $id = $this->addChat([
                'receiver_id'   => $seller->id,
                'subject'       => 'Hello First Chat',
                'product_id'    => $product->id,
                'uuid'          => uniqid(more_entropy:true)
            ]);
            
            $reviewsCount = (new CommonModel)->getReviewsCountByProductId( $product->id );
            $country      = getCountry( $seller->country_id ?? 0 );
            $city         = getCity( $seller->city_id ?? 0 );

            $this->addMessage( $id,[
                'sender_id'    => $seller->id,
                'receiver_id'  => user()->id,
                'message'      => sprintf('
                    <strong>Hello, I am %1$s</strong> <br>
                    <div class="product-details-review">
                        %2$s
                        <span class="review-text">%3$s &nbsp;(%4$d)</span>
                    </div>
                    <div class="location">
                        <svg viewBox="0 0 16 16" width="16" height="16" aria-hidden="true">
                            <path d="M8 0a6.5 6.5 0 0 0-6.5 6.5C1.5 12.99 8 16 8 16s6.5-3.01 6.5-9.5A6.5 6.5 0 0 0 8 0m0 1.5a5 5 0 0 1 5 5c0 4.38-3.52 6.92-5 7.8-1.46-.88-5-3.45-5-7.8a5 5 0 0 1 5-5m0 2.25a2.75 2.75 0 1 0 0 5.5 2.75 2.75 0 0 0 0-5.5m0 1.5a1.25 1.25 0 0 1 0 2.5 1.25 1.25 0 0 1 0-2.5"></path>
                        </svg>
                        <span>%5$s</span>,
                        <span>%6$s</span>
                    </div>',
                    $seller->username,
                    view('partials/_review_stars', ['rating' => $product->rating]),
                    trans("reviews"),
                    numberFormatShort($reviewsCount),
                    $country->name ?? '',
                    $city->name ?? ''
                ),
            ]);

            $chat = $this->builder->where('id',$id)->get()->getRow(type:'array');
        }

        return $chat;
    }

    //add chat
    public function addChat( $data = [
        'receiver_id'   => 0,
        'subject'       => '',
        'product_id'    => 0
    ])
    {
        $data = array_merge([
            'sender_id'     => user()->id,
            'updated_at'    => date("Y-m-d H:i:s"),
            'created_at'    => date("Y-m-d H:i:s")
        ],$data);

        if (empty($data['product_id'])) {
            $data['product_id'] = 0;
        }
        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //add message
    public function addMessage($chatId,$data = [
        'sender_id'    => 0,
        'receiver_id'  => 0,
    ])
    {
        $data = array_merge([
            'chat_id'           => $chatId,
            'is_read'           => 0,
            'deleted_user_id'   => 0,
            'created_at'        => date("Y-m-d H:i:s")
        ],$data);
        
        if ($this->builderMessages->insert($data)) {
            $messageId = $this->db->insertID();
            $this->builder->where('id', clrNum($chatId))->update(['updated_at' => date("Y-m-d H:i:s")]);
            //set cache
            setChatCache($data['receiver_id']);
            //send email
            $this->addMessageEmail($messageId);
            return $messageId;
        }

        return false;
    }

    //add message
    public function addMessageEmail($messageId)
    {
        $message = $this->getMessage($messageId);
        if (!empty($message)) {
            $chat = $this->getChat($message->chat_id);
            $receiver = getUser($message->receiver_id);
            if (!empty($chat) && !empty($receiver) && $receiver->send_email_new_message == 1 && !empty($message->message)) {
                $emailData = [
                    'email_type' => 'new_message',
                    'email_address' => $receiver->email,
                    'email_subject' => trans("you_have_new_message"),
                    'email_data' => serialize(['messageSender' => getUsername(user()), 'messageSubject' => $chat->subject, 'messageText' => $message->message]),
                    'template_path' => 'email/new_message'
                ];
                addToEmailQueue($emailData);
            }
        }
    }

    //get chats by user id
    public function getChats($userId,$limit = null,$offset = 0)
    {
        return $this->builder->select('chat.*,
        user_receiver.username AS receiver_username, user_receiver.first_name AS receiver_first_name, user_receiver.last_name AS receiver_last_name, user_receiver.avatar AS receiver_avatar, user_receiver.role_id AS receiver_role_id,
        user_sender.username AS sender_username, user_sender.first_name AS sender_first_name, user_sender.last_name AS sender_last_name, user_sender.avatar AS sender_avatar, user_sender.role_id AS sender_role_id,
        (SELECT COUNT(chat_messages.id) FROM chat_messages WHERE chat_messages.chat_id = chat.id AND chat_messages.receiver_id = ' . clrNum($userId) . ' AND  is_read = 0) AS num_unread_messages')
            ->join('users AS user_receiver', 'chat.receiver_id = user_receiver.id')
            ->join('users AS user_sender', 'chat.sender_id = user_sender.id')
            ->where('chat.id IN (SELECT DISTINCT chat_messages.chat_id FROM chat_messages WHERE (chat_messages.receiver_id =  ' . clrNum($userId) . ' OR chat_messages.sender_id =  ' . clrNum($userId) . ') AND chat_messages.deleted_user_id !=  ' . clrNum($userId) . ')')
            ->orderBy('num_unread_messages, chat.updated_at', 'DESC')->get($limit,$offset)->getResult();
    }

    //get user unread chats
    public function getUnreadChatsCount($userId)
    {
        return $this->builder->where('chat.id IN (SELECT chat_id FROM chat_messages WHERE receiver_id = ' . clrNum($userId) . ' AND is_read = 0 AND deleted_user_id = 0)')->countAllResults();
    }

    //get chat
    public function getChat($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    //get message
    public function getMessage($id)
    {
        return $this->builderMessages->where('id', clrNum($id))->get()->getRow();
    }

    //get messages
    public function getMessages($chatId,$limit = null,$offset = 0)
    {
        return $this->builderMessages->select('chat_messages.*, (SELECT avatar FROM users WHERE chat_messages.sender_id = users.id LIMIT 1) AS user_avatar')
            ->where('chat_messages.chat_id', clrNum($chatId))->get($limit,$offset)->getResult();
    }

    //get latest messages
    public function getLatestMessages($chatId, $limit)
    {
        return $this->builderMessages->select('chat_messages.*, (SELECT avatar FROM users WHERE chat_messages.sender_id = users.id LIMIT 1) AS user_avatar')
            ->orderBy('id DESC')->where('chat_id', clrNum($chatId))->get(clrNum($limit))->getResult();
    }

    //set chat messages as read
    public function setChatMessagesAsRead($chatId)
    {
        $messages = $this->getUnreadMessages($chatId);
        if (!empty($messages)) {
            foreach ($messages as $message) {
                if ($message->receiver_id == user()->id) {
                    $this->builderMessages->where('id', $message->id)->update(['is_read' => 1]);
                }
            }
        }
    }

    //get unread messages
    public function getUnreadMessages($chatId)
    {
        return $this->builderMessages->where('chat_id', $chatId)->where('receiver_id', user()->id)->where('is_read', 0)
            ->orderBy('id DESC')->get()->getResult();
    }

    //build chats array
    public function getChatsArray($chatId = null)
    {
        $array = [];
        $chats = $this->getChats(user()->id);
        if (!empty($chats)) {
            foreach ($chats as $item) {
                $user = new \stdClass();
                if ($item->receiver_id == user()->id) {
                    $user->username = $item->sender_username;
                    $user->first_name = $item->sender_first_name;
                    $user->last_name = $item->sender_last_name;
                    $user->avatar = $item->sender_avatar;
                    $user->role_id = $item->sender_role_id;
                } else {
                    $user->username = $item->receiver_username;
                    $user->first_name = $item->receiver_first_name;
                    $user->last_name = $item->receiver_last_name;
                    $user->avatar = $item->receiver_avatar;
                    $user->role_id = $item->receiver_role_id;
                }
                $username = $user->first_name . ' ' . $user->last_name;
                if (isVendorByRoleId($user->role_id)) {
                    $username = $user->username;
                }
                if (!empty($user)) {

                    $firstMessage = getFirstMessage($item->id);

                    $item = [
                        'class'             => $item->id === $chatId ? 'active' : '',
                        'product_image'     => getProductMainImage($item->product_id,'image_small'), 
                        'chatId'            => $item->id,
                        'uuid'              => $item->uuid,
                        'username'          => esc($username),
                        'avatar'            => getUserAvatar($user),
                        'subject'           => esc(characterLimiter($item->subject, 280, '...')),
                        'numUnreadMessages' => $item->num_unread_messages,
                        'updatedAt'         => !empty($item->updated_at) ? timeAgo($item->updated_at) : null
                    ];

                    if( $firstMessage && $firstMessage->message ){
                        $item['firstMessage'] = esc(characterLimiter($firstMessage->message, 280, '...'));
                    } elseif ( $firstMessage && $firstMessage->quote_id ) {
                        $quote = getQuoteRequest($firstMessage->quote_id);
                        $item['firstMessage'] = priceFormatted($quote->price_offered,$quote->price_currency,true);
                    }

                    array_push($array, $item);
                }
            }
        }
        return $array;
    }

    //build messages array
    public function getMessagesArray($chatId,$limit = 10)
    {
        $array = [];
        $messages = $this->getLatestMessages($chatId,$limit);
        if (!empty($messages)) {
            foreach ($messages as $message) {
                if ($message->deleted_user_id != user()->id) {
                    $isRight = true;
                    if (user()->id == $message->receiver_id) {
                        $isRight = false;
                    }
                    $item = [
                        'id'         => $message->id,
                        'message'    => $message->message,
                        'avatar'     => getChatUserAvatar($message),
                        'time'       => timeAgo($message->created_at),
                        'isRight'    => $isRight,
                        'isReceiver' => user()->id == $message->receiver_id,
                        'isSender'   => user()->id == $message->sender_id
                    ];

                    if ( $message->quote_id ) {
                        $item['quote']                              = getQuoteRequest($message->quote_id);
                        $item['quote']->price_offered_html          = priceFormatted( $item['quote']->price_offered,$item['quote']->price_currency,true );
                        $item['quote']->seller_price_offered_html   = priceFormatted( $item['quote']->seller_price_offered,$item['quote']->price_currency,true );
                    }

                    array_push($array, $item);
                }
            }
        }
        return $array;
    }

    //check user chat cache
    public function checkUserChatCache($receiverId)
    {
        $cache = \Config\Services::cache();
       
        $hasMessage = false;
        if (!empty($cache->get('chat_cache'))) {
            $array = $cache->get('chat_cache');
            if (!empty($array[$receiverId])) {
                $hasMessage = true;
                $array[$receiverId] = 0;
            }
            $cache->save('chat_cache', $array, 86400);
        }
        return $hasMessage;
    }

    //get all chats count
    public function getChatsAllCount()
    {
        $this->filterChats();
        return $this->builder->countAllResults();
    }

    //get chats all
    public function getChatsAllPaginated($perPage, $offset)
    {
        $this->filterChats();
        return $this->builder->orderBy('updated_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get messages admin
    public function getMessagesAdmin($chatId)
    {
        return $this->builderMessages->select('chat_messages.*, 
        (SELECT username FROM users WHERE chat_messages.sender_id = users.id LIMIT 1) AS sender_username')
            ->where('chat_messages.chat_id', clrNum($chatId))->orderBy('created_at')->get()->getResult();
    }

    //filter chats
    public function filterChats()
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builder->like('subject', $q);
        }
    }

    //delete chat
    public function deleteChat($id)
    {
        $chat = $this->getChat($id);
        if (!empty($chat)) {
            $messages = $this->getMessages($chat->id);
            if (!empty($messages)) {
                foreach ($messages as $message) {
                    if ($message->sender_id == user()->id || $message->receiver_id == user()->id) {
                        if ($message->deleted_user_id == 0) {
                            $data = ['deleted_user_id' => user()->id];
                            $this->builderMessages->where('id', $message->id)->update($data);
                        } else {
                            $this->builderMessages->where('id', $message->id)->delete();
                        }
                    }
                }
            }
            //delete chat if does not have messages
            $messages = $this->getMessages($chat->id);
            if (empty($messages)) {
                $this->builder->where('id', $chat->id)->delete();
            }
        }
    }

    //delete chat permanently
    public function deleteChatPermanently($id)
    {
        $chat = $this->getChat($id);
        if (!empty($chat)) {
            $this->builder->where('id', $chat->id)->delete();
            $this->builderMessages->where('chat_id', $chat->id)->delete();
        }
        return true;
    }

    //delete chat message permanently
    public function deleteChatMessagePermanently($id)
    {
        $message = $this->getMessage($id);
        if (!empty($message)) {
            return $this->builderMessages->where('id', $message->id)->delete();
        }
        return false;
    }
}