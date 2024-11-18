<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= trans("messages"); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title visibility-hidden" style="height: 0; margin: 0;"><?= trans("messages"); ?></h1>
            </div>
            <div class="col-12">
                <?php if (!empty($chats)): ?>
                    <div id="mdsChat" class="row chat position-relative <?= empty($chat) ? 'chat-empty' : ''; ?>">
                        <div class="col chat-left">
                            <div class="chat-left-inner">
                                <div class="chat-user">
                                    <div class="flex-item">
                                        <div class="user-img">
                                            <img src="<?= getUserAvatar(user()); ?>" alt="<?= esc(getUsername(user())); ?>">
                                        </div>
                                        <span class="chat-badge-online"></span>
                                    </div>
                                    <div class="flex-item">
                                        <?= esc(getUsername(user())); ?>
                                    </div>
                                </div>
                                <div class="chat-search d-flex justify-content-between align-items-center">
                                    <div class="position-relative w-md-75">
                                        <input type="text" name="search" id="chatSearchContacts" class="form-control input-search" maxlength="300" placeholder="<?= trans("search"); ?>">
                                        <i class="icon-search"></i>
                                    </div>
                                    <button type="button" class="btn-open-chats button-link">
                                        <strong style="font-size: 30px;">&times;</strong>
                                    </button>
                                </div>
                                <div class="text-recent-chats"><?= trans("recent_chats"); ?></div>
                                <div class="chat-contacts-container mds-scrollbar">
                                    <div id="chatContactsContainer" class="chat-contacts">
                                        <span class="loader"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col chat-right">
                            <?php if ( ! empty( $chat ) ) : ?>
                                <div id="chatUserContainer" class="chat-header">
                                    <div class="text-center p-3 top-header">
                                        <a  href="<?= base_url("profile/{$receiver->slug}"); ?>">
                                            <?= esc(getUsername($receiver)); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 16 16" version="1.1" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                                <polyline points="8.25 2.75,2.75 2.75,2.75 13.25,13.25 13.25,13.25 7.75" />
                                                <path d="m13.25 2.75-5.5 5.5m3-6.5h3.5v3.5" />
                                            </svg>
                                        </a>
                                        <button type="button" class="btn-open-chats button-link"><i class="icon-menu"></i></button>
                                    </div>
                                    <hr>
                                    <div class="product-info p-3 d-flex justify-content-between align-items-center">
                                        <div class="d-inline-block">
                                            <img src="<?= getProductMainImage($product->id,'image_small'); ?>" class="img-thumbnail" style="width: 50px;">
                                            <div class="float-right mx-2">
                                                <a href="<?= generateProductUrl($product); ?>"><strong><?= getProductTitle($product); ?></strong></a>
                                                <div class="item-meta">
                                                    <?= view('product/_price_product_item', ['product' => $product]); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action-btns d-flex justify-content-between align-items-center">
                                            <?php if( user()->id != $product->user_id ): ?>
                                                <button class="btn btn-outline-info" data-toggle="modal" data-target="<?= ! authCheck() ? '#loginModal' : '#priceOfferModal' ?>">Make an offer</button>
                                                <form action="<?= getProductFormData($product)->addToCartUrl ?>" class="mx-2" method="post" id="form_add_cart">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="product_quantity" value="1">
                                                    <input type="hidden" name="product_id" value="<?= $product->id; ?>">
                                                    <button class="btn btn-info" type="submit">Buy</button>
                                                </form>
                                                <?= view('product/details/_offer_send',['product' => getProduct($chat['product_id'])]); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-content">
                                    <div id="chatMessagesContainer" class="messages">
                                        <div id="messagesContainer<?= $chat['id']; ?>" class="messages-inner mds-scrollbar position-relative">
                                            <span class="loader"></span>
                                        </div>
                                    </div>
                                    <div id="chatInputContainer" class="chat-input">
                                        <?php if (!empty($chat)):
                                            echo view('chat/_chat_form', ['chat' => $chat]);
                                        else: ?>
                                            <input type="text" name="message" class="form-control" placeholder="<?= trans('write_a_message'); ?>" autocomplete="off" disabled>
                                            <button type="button" class="btn" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#273244" class="bi bi-send" viewBox="0 0 16 16">
                                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="chat-content">
                                    <div class="select-chat-container">
                                        <button class="badge btn btn-light btn-open-chats button-link" style="font-size: 16px;border-radius: 30px;padding:20px;"><?= trans("select_chat_start_messaging"); ?></button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center"><?= trans("no_messages_found"); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<style>
    @media (max-width: 992px) {
        .chat-left .chat-contacts-container {
            height: 380px !important;
        }

        .chat .chat-content {
            height: 380px !important;
        }
    }
</style>