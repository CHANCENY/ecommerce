<main class="main-content-wrapper">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-md-flex justify-content-between align-items-center">
                    <!-- page header -->
                    <div>
                        <h2>Add New Product</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Products</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- button -->
                    <div>
                        <a href="/shop/products" class="btn btn-light">Back to Product</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <form method="post" enctype="multipart/form-data" class="row">
            <div class="col-lg-8 col-12">
                <!-- card -->
                <div class="card mb-6 card-lg">
                    <!-- card body -->
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Information</h4>
                        <div class="row">
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Title</label>
                                <input name="product_name" type="text" class="form-control" placeholder="Product Name" required="">
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Product Category</label>
                                <select name="product_category" class="form-select">
                                    <option selected="">Product Category</option>
                                    <option value="Dairy, Bread & Eggs">Dairy, Bread & Eggs</option>
                                    <option value="Snacks & Munchies">Snacks & Munchies</option>
                                    <option value="Fruits & Vegetables">Fruits & Vegetables</option>
                                </select>
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Weight</label>
                                <input name="product_weight" type="text" class="form-control" placeholder="Weight" required="">
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Units</label>
                                <select name="product_unit" class="form-select">
                                    <option selected="">Select Units</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div>
                                <div class="mb-3 col-lg-12 mt-5">
                                    <!-- heading -->
                                    <h4 class="mb-3 h5">Product Images</h4>

                                    <!-- input -->
                                    <div class="mt-4 border-dashed rounded-2 min-h-0">
                                        <input type="file" name="product_image[]" class="form-control" multiple min="1" max="4">
                                    </div>
                                </div>
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-12 mt-5">
                                <h4 class="mb-3 h5">Product Descriptions</h4>
                                <textarea name="product_description" class="py-8 form-control" id="editor"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <!-- card -->
                <div class="card mb-6 card-lg">
                    <!-- card body -->
                    <div class="card-body p-6">
                        <!-- input -->
                        <div class="form-check form-switch mb-4">
                            <input name="product_in_stock" value="1" class="form-check-input" type="checkbox" role="switch" id="flexSwitchStock" checked="">
                            <label class="form-check-label" for="flexSwitchStock">In Stock</label>
                        </div>
                        <!-- input -->
                        <div>
                            <div class="mb-3">
                                <label class="form-label">Product Code</label>
                                <input name="product_code" type="text" class="form-control" placeholder="Enter Product code">
                            </div>
                            <!-- input -->
                            <div class="mb-3">
                                <label class="form-label">Product SKU</label>
                                <input name="product_sku" type="text" class="form-control" placeholder="Enter Product SKU">
                            </div>
                            <!-- input -->
                            <div class="mb-3">
                                <label class="form-label" id="productSKU">Status</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_status" id="inlineRadio1" value="1" checked="">
                                    <label class="form-check-label" for="inlineRadio1">Active</label>
                                </div>
                                <!-- input -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="product_status" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">Disabled</label>
                                </div>
                                <!-- input -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
                <div class="card mb-6 card-lg">
                    <!-- card body -->
                    <div class="card-body p-6">
                        <h4 class="mb-4 h5">Product Price</h4>
                        <!-- input -->
                        <div class="mb-3">
                            <label class="form-label">Regular Price</label>
                            <input type="text" name="product_normal_price" class="form-control" placeholder="$0.00">
                        </div>
                        <!-- input -->
                        <div class="mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="text" class="form-control" name="product_discount_price" placeholder="$0.00">
                        </div>
                    </div>
                </div>
                <!-- button -->
                <div class="d-grid">
                    <input name="new_product" type="submit" class="btn btn-primary" value="Create Product">
                </div>
            </div>
        </form>
    </div>
</main>