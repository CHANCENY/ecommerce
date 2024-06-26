<main class="main-content-wrapper">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-md-flex justify-content-between align-items-center">
                    <!-- page header -->
                    <div>
                        <h2>Add New Category</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Categories</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Category</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="/shop/categories" class="btn btn-light">Back to Categories</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-12">
                <!-- card -->
                <div class="card mb-6 shadow border-0">
                    <!-- card body -->
                    <form method="post" enctype="multipart/form-data" class="card-body p-6">
                        <h4 class="mb-5 h5">Category Image</h4>
                        <div class="mb-4 d-flex">
                            <input name="category_image" type="file" class="file-input form-control">
                        </div>
                        <h4 class="mb-4 h5 mt-5">Category Information</h4>

                        <div class="row">
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Category Name</label>
                                <input name="category_name" type="text" class="form-control" placeholder="Category Name" required="">
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Slug</label>
                                <input name="category_slug" type="text" class="form-control" placeholder="Slug" required="">
                            </div>
                            <!-- input -->
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Category vendor</label>
                                <select required name="category_vendor" type="text" class="form-control" >
                                    <?php if(!empty($content['vendors'])): foreach ($content['vendors'] as $vendor): ?>
                                      <option value="<?= $vendor->vendor_id; ?>"><?= $vendor->vendor_name; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label class="form-label">Parent Category</label>
                                <select required name="category_parent" class="form-select">
                                    <option selected="">Category Name</option>
                                    <option value="Dairy, Bread & Eggs">Dairy, Bread & Eggs</option>
                                    <option value="Snacks & Munchies">Snacks & Munchies</option>
                                    <option value="Fruits & Vegetables">Fruits & Vegetables</option>
                                </select>
                            </div>
                            <div></div>
                            <!-- input -->
                            <div class="mb-3 col-lg-12">
                                <label class="form-label">Descriptions</label>

                                <textarea name="category_description" class="py-8 form-control" id="editor"></textarea>
                            </div>

                            <!-- input -->
                            <div class="mb-3 col-lg-12">
                                <label class="form-label" id="productSKU">Status</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="category_status" id="inlineRadio1" value="1" checked="">
                                    <label class="form-check-label" for="inlineRadio1">Active</label>
                                </div>
                                <!-- input -->
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="category_status" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">Disabled</label>
                                </div>
                                <!-- input -->
                            </div>
                            <div class="col-lg-12">
                                <input type="submit" name="new_category" class="btn btn-primary ms-2" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>