<?php $categoryModel = new \App\Models\CategoryModel(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/product/_filter_products', ['categoryModel' => $categoryModel]); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('product'); ?></th>
                            <th><?= trans('product_type'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('purchased_plan'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('status'); ?></th>
                            <th><?= trans('updated'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td class="td-product">
                                        <?php if ($item->is_promoted == 1): ?>
                                            <label class="label label-success"><?= trans("featured"); ?></label>
                                        <?php endif; ?>
                                        <div class="img-table">
                                            <a href="<?= generateProductUrl($item); ?>" target="_blank">
                                                <img src="<?= getProductItemImage($item); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                            </a>
                                        </div>
                                        <a href="<?= generateProductUrl($item); ?>" target="_blank" class="table-product-title">
                                            <?= getProductTitle($item); ?>
                                        </a>
                                    </td>
                                    <td><?= trans($item->product_type); ?></td>
                                    <td>
                                        <?php $category = new stdClass();
                                        $category->name = $item->category_name;
                                        echo getCategoryName($category, $activeLang->id); ?>
                                    </td>
                                    <td>
                                        <?php if ($item->is_promoted == 1 && $item->promote_plan != 'none') {
                                            echo esc($item->promote_plan);
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="<?= generateProfileUrl($item->user_slug); ?>" target="_blank" class="table-username">
                                            <?= esc($item->user_username); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item->is_rejected == 1): ?>
                                            <p>
                                                <label class="label label-danger"><?= trans("rejected"); ?></label>
                                            </p>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalReason<?= $item->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?= trans("show_reason"); ?></button>
                                            <div id="modalReason<?= $item->id; ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title"><?= trans("reason"); ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="m-t-10"><?= esc($item->reject_reason); ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans("close"); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else:
                                            if ($item->status == 1):?>
                                                <label class="label label-success"><?= trans("active"); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default"><?= trans("pending"); ?></label>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td><?= !empty($item->updated_at) ? timeAgo($item->updated_at) : ''; ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans("select_option"); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('product-details/' . $item->id); ?>"><i class="fa fa-info option-icon"></i><?= trans("view_details"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="approveProduct('<?= $item->id; ?>');"><i class="fa fa-check option-icon"></i><?= trans("approve"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalReject" onclick="$('#reject_product_id').val(<?= $item->id; ?>);"><i class="fa fa-ban option-icon"></i><?= trans("reject"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?= generateDashUrl("edit_product") . '/' . $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?= trans("edit"); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProduct','<?= $item->id; ?>','<?= trans("confirm_product", true); ?>');"><i class="fa fa-times option-icon"></i><?= trans('delete'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProductPermanently','<?= $item->id; ?>','<?= trans("confirm_product_permanent", true); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete_permanently'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                            <?php if (count($products) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedProducts('<?= trans("confirm_products", true); ?>');"><?= trans('delete'); ?></button>
                                    <?php if ($listType == 'edited_products'): ?>
                                        <button class="btn btn-sm btn-success btn-table-delete" onclick="approveSelectedEditedProducts('<?= trans("confirm_action", true); ?>');"><?= trans('approve'); ?></button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalReject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Product/rejectProduct'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="reject_product_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= trans("reject"); ?></h4>
                </div>
                <div class="modal-body">
                    <textarea name="reject_reason" class="form-control form-textarea" placeholder="<?= trans("reason"); ?>.." style="min-height: 150px;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>