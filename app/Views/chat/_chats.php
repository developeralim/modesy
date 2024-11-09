<?php foreach ($chats as $item):
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
    $username      = $user->first_name . ' ' . $user->last_name;
    $chat_product  = getActiveProduct($item->product_id);
    $firstMessage  = getFirstMessage($item->id);
    
    if (isVendorByRoleId($user->role_id)) {
        $username = $user->username;
    }
    if (!empty($user)): ?>
        <a class="item" href="<?= base_url("messages/{$item->uuid}") ?>">
            <div class="chat-contact <?php if( ! empty($chat) && $chat['id'] == $item->id ) : print('active'); endif; ?>" data-chat-id="<?= $item->id; ?>">
                <div class="flex-item">
                    <div class="item-img">
                        <img class="profile" src="<?= getUserAvatar($user); ?>" alt="<?= esc($username); ?>">
                    </div>
                </div>
                <div class="flex-item flex-item-center">
                    <h6 class="username">
                        <?= esc($username); ?>
                    </h6>
                    <div class="d-inline-block">
                        <p class="subject">
                            <?php if( $firstMessage && $firstMessage->message ) : ?>
                                <?= esc(characterLimiter($firstMessage->message, 280, '...')); ?>
                            <?php elseif ( $firstMessage && $firstMessage->quote_id ) : $quote = getQuoteRequest($firstMessage->quote_id); ?>
                                <?= priceFormatted($quote->price_offered,$quote->price_currency,true); ?>
                            <?php endif; ?>
                        </p>
                        <img src="<?= getProductMainImage($item->product_id,'image_small'); ?>" class="img-thumbnail" style="width: 50px;">
                    </div>
                    <?php if (!empty($item->updated_at)): ?>
                        <div class="time"><?= timeAgo($item->updated_at); ?></div>
                    <?php endif; ?>
                </div>
                <?php if ($item->num_unread_messages > 0): ?>
                    <div class="flex-item">
                        <label id="chatBadge<?= $item->id; ?>" class="badge badge-success"><?= $item->num_unread_messages ?></label>
                    </div>
                <?php endif; ?>
            </div>
        </a>
<?php endif;
endforeach; ?>