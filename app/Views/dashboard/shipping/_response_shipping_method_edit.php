<?php 
    /**
     * @var \App\Services\Shippings\Interfaces\ShippingInterface
     */
    $resolvedMethod = new \Config\Shippings::$methods[$method->method_type];
    $resolvedMethod->setEntity( $method );
    $resolvedMethod->setSeller(getUser( $method->user_id ));
?>
<div id="row_shipping_method_<?= $resolvedMethod->uniqid; ?>" class="row">
    <div class="col-sm-12">
        <div class="response-shipping-method">
            <span class="title"><?= $resolvedMethod->getReadableName() ?></span>
            <div id="modalMethod<?= $resolvedMethod->uniqid; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                            <h4 class="modal-title"><?= $resolvedMethod->getReadableName() ?></h4>
                        </div>
                        <div class="modal-body"><?= $resolvedMethod->renderInputForm(); ?></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans("close"); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-group btn-group-option">
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalMethod<?= $resolvedMethod->uniqid; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default" data-toggle="tooltip" title="<?= trans('delete'); ?>"  data-id="<?= $resolvedMethod->uniqid; ?>" onclick='deleteShippingMethod("<?= $method->id; ?>","<?= trans("confirm_delete", true); ?>","<?= $resolvedMethod->uniqid ?>");'><i class="fa fa-trash-o"></i></a>
            </div>
        </div>
    </div>
</div>