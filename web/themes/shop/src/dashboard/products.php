<main class="main-content-wrapper">
    <div class="container">
        <div class="row mb-8">
            <div class="col-md-12">
                <!-- page header -->
                <div class="d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2>Products</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Products</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- button -->
                    <div>
                        <a href="/shop/products/new" class="btn btn-primary">Add Product</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-12 mb-5">
                <!-- card -->
                <div class="card h-100 card-lg">
                    <div class="px-6 py-6">
                        <div class="row justify-content-between">
                            <!-- form -->
                            <div class="col-lg-4 col-md-6 col-12 mb-2 mb-lg-0">
                            </div>
                            <!-- select option -->
                            <div class="col-lg-2 col-md-4 col-12">
                                <select id="actions" class="form-select">
                                    <option selected="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactivate</option>
                                    <option value="3">Out stock</option>
                                    <option value="4">In stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- card body -->
                    <div class="card-body p-0">
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table datatable table-centered table-hover text-nowrap table-borderless mb-0 table-with-checkbox">
                                <thead class="bg-light">
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Create at</th>
                                    <th>Vendor</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(!empty($content['products'])): foreach ($content['products'] as $product): ?>

                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input data="<?= $product->product_id; ?>" class="form-check-input checkboxes" type="checkbox" value="" id="productOne<?= $product->product_id; ?>">
                                            <label class="form-check-label" for="productOne<?= $product->product_id; ?>"></label>
                                        </div>
                                    </td>
                                    <?php $images = \Mini\Modules\contrib\products\src\Plugin\Products::productImages($product->product_image);
                                     $image = !empty($images) ? reset($images) : null;
                                     $category = \Mini\Modules\contrib\products\src\Plugin\Products::getProductCategory($product->product_category);
                                    ?>
                                    <td>
                                        <a href="#!"><img src="<?= $image ?>" alt="" class="icon-shape icon-md"></a>
                                    </td>
                                    <td><a href="#" class="text-reset"><?= $product->product_name ?></a></td>
                                    <td><?= $category->category_name ?? null; ?></td>

                                    <td>
                                        <?php if($product->product_status === 1): ?>
                                            <?php if($product->product_in_stock === 1): ?>
                                               <span class="badge bg-light-primary text-dark-primary">Active/In stock</span>
                                            <?php else: ?>
                                                <span class="badge bg-light-warning text-dark-warning">Active/Out stock</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                           <?php if($product->product_in_stock === 1): ?>
                                            <span class="badge bg-light-danger text-dark-danger">Deactivate/In stock</span>
                                           <?php else: ?>
                                               <span class="badge bg-light-warning text-dark-warning">Deactivate/Out stock</span>
                                           <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $product->product_normal_price ?></td>
                                    <td><?= $product->products_created ?></td>
                                    <td>
                                        <?php $vendor = \Mini\Modules\contrib\products\src\Plugin\Products::getProductVendor($product->product_vendor);
                                        $vendor_name = null;
                                        if($vendor) {
                                            $vendor_name = $vendor->vendor_name;
                                        }
                                        echo $vendor_name;
                                        ?>
                                    </td>
                                </tr>

                                <?php endforeach; endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const actions_triggers = document.getElementById('actions');
    if(actions_triggers) {
        actions_triggers.addEventListener('change',(e)=>{
            const checkboxes = document.querySelectorAll('.checkboxes');
            const actions = [];
            Array.from(checkboxes).forEach((item)=>{
                if(item.checked) {
                    actions.push({product_id: item.getAttribute('data'), action: e.target.value})
                }
            });
            if(actions) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/shop/products',true);
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
