<div class="row">
    <div class="col-sm-12">
        <?= view('dashboard/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                                <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= trans("filter"); ?>
                            </button>
                            <div class="collapse navbar-collapse" id="collapseFilter">
                                <form action="<?= generateDashUrl('sales/shipment/' . $shipping->getShippingId()); ?>" method="get" id="formVendorSales">
                                    <div class="item-table-filter">
                                        <label><?= trans("shipping"); ?></label>
                                        <select name="shipping_method" class="form-control custom-select">
                                            <option value="" selected><?= trans("all"); ?></option>
                                            <?php foreach( $shipping->methods as $methodType => $method ) : $method = new $method  ?>
                                                <option value="<?= $methodType ?>" <?= inputGet('shipping_method') == $methodType ? 'selected' : ''; ?>><?= $method->getTitle(); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="item-table-filter item-table-filter-large">
                                        <label><?= trans("search"); ?></label>
                                        <div class="item-table-filter-search">
                                            <input name="q" class="form-control" placeholder="<?= trans("sale_id"); ?>" type="search" value="<?= strSlug(esc(inputGet('q'))); ?>">
                                            <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
                                            <div class="btn-group table-export">
                                                <button type="button" class="btn btn-default dropdown-toggle btn-table-export" data-toggle="dropdown"><?= trans("export"); ?>&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <button type="button" class="btn-export-data" data-export-form="formVendorSales" data-export-type="vendor_sales" data-export-file-type="csv" data-section="vn">CSV</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="btn-export-data" data-export-form="formVendorSales" data-export-type="vendor_sales" data-export-file-type="xml" data-section="vn">XML</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="btn-export-data" data-export-form="formVendorSales" data-export-type="vendor_sales" data-export-file-type="excel" data-section="vn"><?= trans("excel"); ?>&nbsp;(.xlsx)</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th scope="col"><?= trans("status"); ?></th>
                            <th scope="col"><?= trans("order"); ?></th>
                            <th scope="col"><?= trans("user_contract"); ?></th>
                            <th scope="col"><?= trans("shipping_settings"); ?></th>
                            <th scope="col"><?= trans("insurance_amount"); ?></th>
                            <th scope="col"><?= trans("tracking"); ?></th>
                            <th scope="col"><?= trans("labels"); ?></th>
                            <th scope="col"><?= trans("return_labels"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($shipments)): ?>
                            <?php foreach ($shipments as $shipment):
                                if ( ! empty( $shipment ) ): 
                                    $shipping->setOrder( $shipment );
                                    $shipping->setBuyer( user( $shipment->buyer_id ) ); 
                                ?>
                                    <tr>
                                        <td>
                                            <?php if ($shipping->getOrder()->status == 2): ?>
                                                <label class="label label-danger"><?= trans("cancelled"); ?></label>
                                            <?php else: ?>
                                                <label class="label label-success"><?= trans("order_processing"); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div>
                                                <a href="">#<?= $shipping->getOrder()->order_number; ?></a> 
                                                <span>By</span>
                                                <a href="#">
                                                    <?php 
                                                        echo sprintf(
                                                            "%s - %s (%s)",
                                                            $shipping->getBuyerShippingAddress()->sFirstName,
                                                            $shipping->getBuyerShippingAddress()->sLastName,
                                                            $shipping->getBuyerShippingAddress()->sEmail
                                                        )
                                                    ?>
                                                </a>
                                                <br>
                                                <span>Shipped to</span>
                                                <a href="#">
                                                    <?php 
                                                        echo sprintf(
                                                            "%s (%s)",
                                                            $shipping->getBuyerShippingAddress()->sTitle,
                                                            $shipping->getBuyerShippingAddress()->sZipCode,
                                                        )
                                                    ?>
                                                </a>
                                                <br>
                                                <span style="color: #666;">
                                                    <?php 
                                                        echo sprintf(
                                                            "%s - %s",
                                                            $shipping->getShippingName(),
                                                            $shipping->getMethodName(),
                                                        )
                                                    ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="" id="" class="custom-select">
                                                <option value="">Test Contract</option>
                                            </select>
                                        </td>
                                        <td style="width: 200px;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group m-b-5">
                                                        <label>Parcels Number</label>
                                                        <input type="number" name="parcels_number" class="form-control" value="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group m-b-5">
                                                        <label>Weight</label>
                                                        <input type="number" name="parcels_number" class="form-control" value="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group m-b-5">
                                                        <label>Height</label>
                                                        <input type="number" name="parcels_number" class="form-control" value="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group m-b-5">
                                                        <label>Length</label>
                                                        <input type="number" name="parcels_number" class="form-control" value="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group m-b-5">
                                                        <label>Width</label>
                                                        <input type="number" name="parcels_number" class="form-control" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $shipping->insuranceAmount(); ?>
                                        </td>
                                        <td>
                                            <?= $shipping->trackingNumber(); ?>
                                        </td>
                                        <td>
                                            <form action="<?= generateDashUrl('sales/shipment/generate-label'); ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="shipping" value="<?= $shipping->getShippingId(); ?>">
                                                <input type="hidden" name="shipment" value="<?= $shipping->getOrder()->id; ?>">
                                                <button type="submit" class="btn btn-sm btn-primary">Generate label</button>
                                            </form>
                                        </td>
                                        <td>
                                        
                                        </td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($shipments)): ?>
                    <p class="text-center">
                        <?= trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($shipments)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $numRows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?= $pager->links; ?>
                </div>
            </div>
        </div>
    </div>
</div>