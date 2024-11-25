<?php 
    /**
     * @var \App\Services\Shippings\Interfaces\ShippingInterface $method
     */
?>
<div id="row_shipping_method_<?= $method->uniqid; ?>" class="row">
    <div class="col-sm-12">
        <div class="response-shipping-method">
            <span class="title"><?= trans($selectedOption); ?></span>
            <div id="modalMethod<?= $method->uniqid; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                            <h4 class="modal-title"><?= trans($selectedOption); ?></h4>
                        </div>
                        <div class="modal-body"><?= $method->renderInputForm(); ?></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans("close"); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-group btn-group-option">
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalMethod<?= $method->uniqid; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete-shipping-method" data-toggle="tooltip" title="<?= trans('delete'); ?>"  data-id="<?= $method->uniqid; ?>"><i class="fa fa-trash-o"></i></a>
            </div>
        </div>
    </div>
</div>