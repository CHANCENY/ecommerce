<?php

use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\customers\src\Modal\Address;

/**@var $order RecordCollection **/

$order = $content['order'] ?? null;
 
/**@var $items RecordCollection **/
$items = $content['items'] ?? null;

$user = \Mini\Cms\Entities\User::load($order->order_by);

$address = new Address();
$address = $address->get($order->shipping_address_id)->getAt(0);

$customer_address = \Mini\Modules\contrib\order\src\Plugin\OrderHandler::shippingAddress($address->address_field_id);

$country = new \Mini\Cms\Modules\Respositories\Territory\Country($customer_address['country_code']);

$product = new \Mini\Modules\contrib\products\src\Modal\ProductModal();
$product_image = new \Mini\Modules\contrib\products\src\Modal\ProductImageModal();

$sub_total = 0;

$configs = Services::create('config.factory');
$platform_system = $configs->get('platform_systems');
?>
<main class="main-content-wrapper">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <div>
                        <!-- page header -->
                        <h2>Order</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Order</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- button -->
                    <div>
                        <a href="/shop/orders" class="btn btn-primary">Back to all orders</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-12 mb-5">
                <!-- card -->
                <div class="card h-100 card-lg">
                    <div class="card-body p-6">
                        <div class="d-md-flex justify-content-between">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <h2 class="mb-0">Order ID: #<?= $order->common_id ?></h2>
                                <?php if($order->order_status === 0): ?>
                                    <span class="badge bg-light-warning text-dark-warning ms-2">Pending</span>
                                <?php elseif($order->order_status === 1): ?>
                                    <span class="badge bg-light-primary text-dark-primary ms-2">Confirmed</span>
                                <?php elseif($order->order_status === 2): ?>
                                    <span class="badge bg-light-info text-dark-info ms-2">Shipping</span>
                                <?php elseif($order->order_status === 3): ?>
                                    <span class="badge bg-light-primary text-dark-primary ms-2">Delivered</span>
                                <?php elseif ($order->order_status === 4): ?>
                                    <span class="badge bg-light-danger text-dark-danger ms-2">Cancel</span>
                                <?php endif; ?>
                            </div>
                            <!-- select option -->
                            <div class="d-md-flex">
                                <div class="mb-2 mb-md-0">
                                    <select id="actions" class="form-select">
                                        <option selected="">Status</option>
                                        <option value="1">Confirmed</option>
                                        <option value="2">Shipping</option>
                                        <option value="3">Delivered</option>
                                        <option value="4">Cancel</option>
                                    </select>
                                </div>
                                <!-- button -->
                                <div class="ms-md-3">
                                    <a href="#" class="btn btn-secondary">Download Invoice</a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="row">
                                <!-- address -->
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="mb-6">
                                        <h6>Customer Details</h6>
                                        <p class="mb-1 lh-lg">
                                            <?= $user->getFirstname(). ' '.$user->getLastname(); ?>
                                            <br>
                                            <?= $user->getEmail(); ?>
                                            <br>
                                        </p>
                                        <a href="/user/<?= $user->getUid(); ?>">View Profile</a>
                                    </div>
                                </div>
                                <!-- address -->
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="mb-6">
                                        <h6>Shipping Address</h6>
                                        <p class="mb-1 lh-lg">
                                            <?= $address->firstname .' '.$address->lastname; ?>
                                            <br>
                                            <?= $customer_address['address_1'] ?? null; ?>
                                            <br>
                                            <?= $country->getName().', '.$customer_address['zip_code'] ?? null; ?>
                                            <br>
                                            Contact No. <?= $address->phone_number; ?>
                                        </p>
                                    </div>
                                </div>
                                <!-- address -->
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="mb-6">
                                        <h6>Order Details</h6>
                                        <p class="mb-1 lh-lg">
                                            Order ID:
                                            <span class="text-dark"><?= $order->common_id; ?></span>
                                            <br>
                                            Order Date:
                                            <span class="text-dark"><?= (new DateTime($order->customer_orders_created))->format('F d, Y'); ?></span>
                                            <br>
                                            Order Total:
                                            <span class="text-dark"><?= $order->amount ?? 0.0; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <!-- Table -->
                                <table class="table mb-0 text-nowrap table-centered">
                                    <!-- Table Head -->
                                    <thead class="bg-light">
                                    <tr>
                                        <th>Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <!-- tbody -->
                                    <tbody>
                                    <?php if(!empty($items)): foreach ($items as $item): ?>
                                      <?php if($item instanceof RecordCollection): ?>
                                          <?php
                                            $prod = $product->get($item->product_id)->getAt(0);
                                            $prod_image = $product_image->get($prod->product_image, 'common_id')->getAt(0);
                                            $image_path = null;
                                            if($prod_image->fid) {
                                             $file = \Mini\Cms\Modules\FileSystem\File::load($prod_image->fid);

                                             $image_path = '/' .trim($file->getFilePath(true), '/');
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-inherit">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <img src="<?= $image_path ?>" alt="<?= $item->product_name?>" class="icon-shape icon-lg">
                                                            </div>
                                                            <div class="ms-lg-4 mt-2 mt-lg-0">
                                                                <h5 class="mb-0 h6"><?= $item->product_name?></h5>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td><span class="text-body"><?= $item->product_price ?></span></td>
                                                <td><?= $item->product_quantity ?></td>
                                                <td><?= $item->product_quantity * $item->product_price ?></td>
                                                <?php $sub_total += $item->product_quantity * $item->product_price;  ?>
                                            </tr>
                                      <?php endif; ?>
                                    <?php endforeach; endif; ?>
                                    <tr>
                                        <td class="border-bottom-0 pb-0"></td>
                                        <td class="border-bottom-0 pb-0"></td>
                                        <td colspan="1" class="fw-medium text-dark">
                                            <!-- text -->
                                            Sub Total :
                                        </td>
                                        <td class="fw-medium text-dark">
                                            <!-- text -->
                                            <?= $sub_total ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-bottom-0 pb-0"></td>
                                        <td class="border-bottom-0 pb-0"></td>
                                        <td colspan="1" class="fw-medium text-dark">
                                            <!-- text -->
                                            Platform fees
                                        </td>
                                        <td class="fw-medium text-dark">
                                            <!-- text -->
                                            <?= $platform_system['platform_fees'] ?? 10; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="1" class="fw-semibold text-dark">
                                            <!-- text -->
                                            Grand Total
                                        </td>
                                        <td class="fw-semibold text-dark">
                                            <!-- text -->
                                            <?= $platform_system['platform_fees'] + $sub_total; ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-6">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-lg-0">
                                <h6>Payment Info</h6>
                                <span>Cash on Delivery</span>
                            </div>
                            <form method="post" class="col-md-6">
                                <h5>Notes</h5>
                                <span>this note will be sent to customer who placed this order</span>
                                <textarea name="order_note_value" class="form-control mb-3" rows="3" placeholder="Write note for order"><?= $order->order_note; ?></textarea>
                                <input name="order_note" type="submit" class="btn btn-primary" value="Save Notes">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="d-none checkboxes" data="<?= $order->order_id ?>"></div>
<script>
    const actions_triggers = document.getElementById('actions');
    if(actions_triggers) {
        actions_triggers.addEventListener('change',(e)=>{
            const checkboxes = document.querySelectorAll('.checkboxes');
            const actions = [];
            Array.from(checkboxes).forEach((item)=>{
                actions.push({order_id: item.getAttribute('data'), status: e.target.value})
            });
            if(actions) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/shop/orders',true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if(this.status){
                        window.location.reload();
                    }
                }
                xhr.send(JSON.stringify({actions: actions}));
            }
        })
    }
</script>
