<?php if (!empty($chat)): ?>
    <div id="messagesContainer<?= $chat['id']; ?>" class="messages-inner mds-scrollbar">
        <?php if (!empty($messages)):
            foreach ($messages as $item):
                if ($item->deleted_user_id != user()->id):
                    if (user()->id == $item->receiver_id):?>
                        <div id="chatMessage<?= $item->id; ?>" class="message">
                            <div class="flex-item item-user">
                                <div class="user-img">
                                    <img src="<?= getChatUserAvatar($item); ?>" alt="" class="img-profile">
                                </div>
                            </div>
                            <div class="flex-item">
                                <?php if ( $item->quote_id ) : $quote = $biddingModel->getQuoteRequest( $item->quote_id ); ?>
                                    <div class="quote-request">
                                        <div class="quote-prices">
                                            <strong><?= priceFormatted($quote->price_offered, $quote->price_currency, true); ?></strong> 
                                            <del><?= priceFormatted($product->price,$product->currency,true); ?></del>
                                        </div>
                                        <div class="quote-status status_<?=$quote->status?> mt-2">
                                            <?= match( $quote->status ){
                                                'pending_quote'     => sprintf('
                                                    <strong class="mb-1 d-block">%10$s</strong>
                                                    %2$s
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <form action="%1$s" method="post">
                                                            %2$s
                                                            <input type="hidden" name="id" class="form-control" value="%3$d">
                                                            <input type="hidden" name="back_url" class="form-control" value="%4$s">
                                                            <button type="submit" class="btn btn-sm btn-success color-white m-b-5">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#ffffff" width="14" height="14">
                                                                    <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                                                </svg>&nbsp;  %5$s
                                                            </button>
                                                        </form>
                                                        <form action="%6$s" method="post" class="mx-2">
                                                            %2$s
                                                            <input type="hidden" name="id" class="form-control" value="%3$d">
                                                            <input type="hidden" name="back_url" class="form-control" value="%4$s">
                                                            <button type="submit" class="btn btn-sm btn-danger color-white m-b-5">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#ffffff" width="14" height="14">
                                                                    <path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/>
                                                                </svg>&nbsp; %7$s
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-light" onclick="deleteQuoteRequest(%3$d,`%8$s`);">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#6c757d" width="14" height="14">
                                                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                                            </svg> %9$s
                                                        </button>
                                                    </div>',
                                                    base_url('accept-quote-post'),
                                                    csrf_field(),
                                                    $quote->id,
                                                    getCurrentUrl(),
                                                    trans("accept_quote"),
                                                    base_url('reject-quote-post'),
                                                    trans("reject_quote"),
                                                    trans("confirm_quote_request", true),
                                                    trans("delete_quote"),
                                                    trans("pending_quote"),
                                                ),
                                                'rejected_quote'    => sprintf('
                                                    <strong class="d-block mb-2">%1$s</strong>
                                                    <button type="button" class="btn btn-sm btn-light" onclick="deleteQuoteRequest(%2$d,`%3$s`);">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#6c757d" width="14" height="14">
                                                            <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                                        </svg> %4$s
                                                    </button>',
                                                    trans("cancelled"),
                                                    $quote->id,
                                                    trans("confirm_quote_request", true),
                                                    trans("delete_quote")
                                                ),
                                                'pending_payment'   => sprintf('
                                                    <strong class="d-block mb-2">%1$s</strong>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <button type="button" class="btn btn-sm btn-light" onclick="deleteQuoteRequest(%2$d,`%3$s`);">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#6c757d" width="14" height="14">
                                                                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                                            </svg> %4$s
                                                        </button>
                                                        <form action="%5$s" method="post" class="mx-2">
                                                            %8$s
                                                            <input type="hidden" name="id" class="form-control" value="%2$d">
                                                            <input type="hidden" name="back_url" class="form-control" value="%6$s">
                                                            <button type="submit" class="btn btn-sm btn-danger color-white m-b-5">
                                                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                                                    width="800px" height="800px" viewBox="0 0 494.936 494.936"
                                                                    xml:space="preserve">
                                                                <g>
                                                                    <g>
                                                                        <path d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157
                                                                            c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21
                                                                            s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741
                                                                            c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                                                        <path d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069
                                                                            c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963
                                                                            c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692
                                                                            C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107
                                                                            l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005
                                                                            c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                                                                    </g>
                                                                </g>
                                                                </svg>&nbsp; %7$s
                                                            </button>
                                                        </form>
                                                    </div>',
                                                    trans("pending_payment"),
                                                    $quote->id,
                                                    trans("confirm_quote_request", true),
                                                    trans("delete_quote"),
                                                    base_url('reject-quote-post'),
                                                    getCurrentUrl(),
                                                    trans("reject_quote"),
                                                    csrf_field(),
                                                ),
                                                default             => trans('closed')
                                            }; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="message-text">
                                        <?= $item->message; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="time"><span><?= timeAgo($item->created_at); ?></span></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div id="chatMessage<?= $item->id; ?>" class="message message-right">
                            <div class="flex-item">
                                <?php if ( $item->quote_id ) : $quote = $biddingModel->getQuoteRequest( $item->quote_id ); ?>
                                    <div class="quote-request">
                                        <div class="quote-prices">
                                            <strong><?= priceFormatted($quote->price_offered, $quote->price_currency, true); ?></strong> 
                                            <del><?= priceFormatted($product->price,$product->currency,true); ?></del>
                                        </div>
                                        <div class="quote-status status_<?=$quote->status?>">
                                            <?= match( $quote->status ){
                                                'pending_quote'     => trans('on_hold'),
                                                'rejected_quote'    => trans('cancelled'),
                                                'pending_payment'   => sprintf(
                                                    '<form action="%s" method="post" class="mt-3">
                                                        <p><strong>%s : %d</strong></p>
                                                        %s
                                                        <input type="hidden" name="id" class="form-control" value="%d">
                                                        <button type="submit" class="btn btn-sm btn-info color-white m-b-5"><i class="icon-cart-solid"></i>&nbsp;%s</button>
                                                    </form>',
                                                    base_url('add-to-cart-quote'),
                                                    trans('quantity'),
                                                    1,
                                                    csrf_field(),
                                                    $quote->id,
                                                    trans("add_to_cart")
                                                ),
                                                default             => trans('closed')
                                            }; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="message-text">
                                        <?= $item->message; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="time"><span><?= timeAgo($item->created_at); ?></span></div>
                            </div>
                            <div class="flex-item item-user">
                                <div class="user-img">
                                    <img src="<?= getChatUserAvatar($item); ?>" alt="" class="img-profile">
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endif;
            endforeach;
        endif; ?>
    </div>
<?php endif; ?>