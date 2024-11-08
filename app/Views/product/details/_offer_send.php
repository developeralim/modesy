<div class="modal fade" id="priceOfferModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <div class="title mb-2"><?= trans("offer"); ?></div>
                <form action="<?= base_url('request-quote-post'); ?>" novalidate="novalidate" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?= $product->id; ?>">
                    <div class="product-info p-3">
                        <div class="d-inline-block">
                            <img src="<?= getProductMainImage($product->id,'image_small'); ?>" class="img-thumbnail" style="width: 50px;">
                            <div class="float-right mx-2">
                                <a href="<?= generateProductUrl($product); ?>"><strong><?= esc($title); ?></strong></a>
                                <div class="item-meta">
                                    <?= trans("item_price"); ?> : <?= view('product/_price_product_item', ['product' => $product]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="d-flex justify-content-between align-items-center p-0 m-0 offer-price-picker">
                        <li>
                            <label for="price-10-off">
                                <strong><?= priceFormatted( $price_10_p = $product->price - (( $product->price * 10 ) / 100), $product->currency, true); ?></strong><br>
                                <input type="radio" id="price-10-off" name="bid" value="<?= $price_10_p; ?>">
                                <span>10% discount</span> 
                            </label>
                        </li>
                        <li>
                            <label for="price-20-off">
                                <strong><?= priceFormatted( $price_20_p = $product->price - (( $product->price * 20 ) / 100), $product->currency, true); ?></strong><br>
                                <input type="radio" id="price-20-off" name="bid" value="<?= $price_20_p; ?>">
                                <span>20% discount</span> 
                            </label>
                        </li>
                        <li>
                            <label for="price-custom">
                                <strong><?= trans('custom'); ?></strong><br>
                                <input type="radio" id="price-custom" name="bid" value="custom">
                                <span>Offer a price</span> 
                            </label>
                        </li>
                    </ul>
                    <div class="custom-input mb-2" style="display: none;">
                        <input type="number" name="custom_price" class="form-control" placeholder="<?= $product->price . ' ' . getCurrencySymbol( $product->currency ) ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-custom btn-block send-proposal-btn" data-currency="<?= getCurrencySymbol( $product->currency ); ?>" data-text="<?= trans("send_proposal"); ?>"><?= trans("send_proposal"); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>