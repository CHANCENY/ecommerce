<main>
    <section class="mt-8">
        <div class="container">
            <div class="hero-slider">
                <div style="background: url('/themes/shop/assets/images/slider/slide-1.jpg') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Opening Sale Discount 50%</span>

                        <h2 class="text-dark display-5 fw-bold mt-4">SuperMarket For Fresh Grocery</h2>
                        <p class="lead">Introduced a new model for online grocery shopping and convenient home delivery.</p>
                        <a href="/shopping" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div style="background: url('/themes/shop/assets/images/slider/slider-2.jpg') no-repeat; background-size: cover; border-radius: 0.5rem; background-position: center">
                    <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
                        <span class="badge text-bg-warning">Free Shipping - orders over $100</span>
                        <h2 class="text-dark display-5 fw-bold mt-4">
                            Free Shipping on
                            <br>
                            orders over
                            <span class="text-primary">$100</span>
                        </h2>
                        <p class="lead">Free Shipping to First-Time Customers Only, After promotions and discounts are applied.</p>
                        <a href="/shopping" class="btn btn-dark mt-3">
                            Shop Now
                            <i class="feather-icon icon-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(!empty($content['categories'])): ?>
    <!-- Category Section Start-->
    <section class="mb-lg-10 mt-lg-14 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0">Featured Categories</h3>
                </div>
            </div>
            <div class="category-slider">

                <?php foreach ($content['categories'] as $category): ?>
                <?php if($category instanceof \Mini\Cms\Modules\Modal\RecordCollection ):?>
                    <?php
                      $file = \Mini\Cms\Modules\FileSystem\File::load($category->category_image);
                      $image_path = '/'. $file->getFilePath(true);
                    ?>
                <div class="item">
                    <a href="/shopping/products/<?= $category->category_name; ?>" class="text-decoration-none text-inherit">
                        <div class="card card-product mb-lg-4">
                            <div class="card-body text-center py-8">
                                <img src="<?= $image_path; ?>" alt="" class="mb-3 img-fluid">
                                <div class="text-truncate"><?= $category->category_name; ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Category Section End-->
    <?php endif; ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                    <div>
                        <div class="py-10 px-8 rounded" style="background: url(/themes/shop/assets/images/banner/grocery-banner.png) no-repeat; background-size: cover; background-position: center">
                            <div>
                                <h3 class="fw-bold mb-1">Fruits & Vegetables</h3>
                                <p class="mb-4">
                                    Get Upto
                                    <span class="fw-bold">30%</span>
                                    Off
                                </p>
                                <a href="/shopping" class="btn btn-dark">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div>
                        <div class="py-10 px-8 rounded" style="background: url(/themes/shop/assets/images/banner/grocery-banner-2.jpg) no-repeat; background-size: cover; background-position: center">
                            <div>
                                <h3 class="fw-bold mb-1">Freshly Baked Buns</h3>
                                <p class="mb-4">
                                    Get Upto
                                    <span class="fw-bold">25%</span>
                                    Off
                                </p>
                                <a href="/shopping" class="btn btn-dark">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(!empty($content['popular'])): ?>
    <!-- Popular Products Start-->
    <section class="my-lg-14 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-6">
                    <h3 class="mb-0">Popular Products</h3>
                </div>
            </div>

            <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">
                <?php foreach ($content['popular'] as $product): ?>
                <?php if($product instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                    <?php
                     $image = $content['product_image_modal']->get($product->product_image, 'common_id')->getAt(0);
                     $image_url = null;
                     if($image) {
                         $file = \Mini\Cms\Modules\FileSystem\File::load($image->fid);
                         $image_url = '/'. $file->getFilePath(true);
                     }
                    ?>
                <div class="col" data-aos="fade-up" data-aos-duration="3000">
                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <div class="position-absolute top-0 start-0">
                                    <?php if($product->product_on_sale): ?>
                                    <span class="badge bg-danger">Sale</span>
                                    <?php elseif($product->product_on_discount): ?>
                                        <span class="badge bg-success"><?= $product->product_discount_percentage; ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="/shopping/product/<?= $product->product_id; ?>"><img src="<?= $image_url ?>" alt="" class="mb-3 img-fluid"></a>

                                <div class="card-product-action">
                                    <a href="#!" onclick="viewProduct(<?= $product->product_id; ?>)" class="btn-action quick-view" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                        <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>
                                    </a>
                                    <a href="/shopping/product/<?= $product->product_id ?>/wishlist" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                </div>
                            </div>
                            <div class="text-small mb-1">
                                <?php
                                  $category = new \Mini\Modules\contrib\dashboard\src\Modal\Category();
                                  $cate = $category->get($product->product_category)->getAt(0);
                                ?>
                                <a href="/shopping/products/<?= $cate->category_name; ?>" class="text-decoration-none text-muted"><small><?= $cate->category_name; ?></small></a>
                            </div>
                            <h2 class="fs-6"><a href="/shopping/product/<?= $product->product_id; ?>" class="text-inherit text-decoration-none"><?= $product->product_name; ?></a></h2>
                            <div>
                                <?php
                                $reviews = new \Mini\Modules\contrib\reviews\src\Plugin\Reviews();
                                $rating = $reviews->getRatingAverage($product->product_id);
                                $filled = array_fill(0,$rating,1);
                                ?>
                                <small class="text-warning">
                                    <?php for($i = 0; $i < 5; $i++): ?>
                                    <?php if(isset($filled[$i])): ?>
                                    <i class="bi bi-star-fill" onclick="addRating(<?= $i ?>,<?= $product->product_id; ?>)"></i>
                                    <?php else: ?>
                                    <i class="bi bi-star" onclick="addRating(<?= $i ?>,<?= $product->product_id; ?>)"></i>
                                    <?php endif;
                                    endfor; ?>
                                </small>
                                <span class="text-muted small"><?= $rating ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <?php if($product->product_discount_price): ?>
                                    <span class="text-dark"><?= $product->product_discount_price ?></span>
                                    <span class="text-decoration-line-through text-muted"><?= $product->product_normal_price ?></span>
                                    <?php else: ?>
                                        <span class="text-dark"><?= $product->product_normal_price ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a href="/shopping/product/<?= $product->product_id ?>/cart" class="btn btn-primary btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- Popular Products End-->
    <?php endif; ?>

    <?php if(!empty($content['best_sells'])): ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-6">
                    <h3 class="mb-0">Daily Best Sells</h3>
                </div>
            </div>
            <div class="table-responsive-lg pb-6">
                <div class="row row-cols-lg-4 row-cols-1 row-cols-md-2 g-4 flex-nowrap">
                    <div class="col">
                        <div class="pt-8 px-6 px-xl-8 rounded" style="background: url(assets/images/banner/banner-deal.jpg) no-repeat; background-size: cover; height: 470px">
                            <div>
                                <h3 class="fw-bold text-white">100% Organic Coffee Beans.</h3>
                                <p class="text-white">Get the best deal before close.</p>
                                <a href="/shopping" class="btn btn-primary">
                                    Shop Now
                                    <i class="feather-icon icon-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($content['best_sells'] as $product): ?>
                    <?php if($product instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                        <?php
                        $image = $content['product_image_modal']->get($product->product_image, 'common_id')->getAt(0);
                        $image_url = null;
                        if($image) {
                            $file = \Mini\Cms\Modules\FileSystem\File::load($image->fid);
                            $image_url = '/'. $file->getFilePath(true);
                        }
                        ?>
                    <div class="col" data-aos="fade-left" data-aos-offset="500" data-aos-duration="500">
                        <div class="card card-product">
                            <div class="card-body">
                                <div class="text-center position-relative">
                                    <a href="/shopping/product/<?= $product->product_id; ?>"><img src="<?=  $image_url; ?>" alt="" class="mb-3 img-fluid"></a>

                                    <div class="card-product-action">
                                        <a href="#!" onclick="viewProduct(<?= $product->product_id; ?>)" class="btn-action" data-bs-toggle="modal" data-bs-target="#quickViewModal">
                                            <i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" title="Quick View"></i>
                                        </a>
                                        <a href="/shopping/product/<?= $product->product_id ?>/wishlist" class="btn-action" data-bs-toggle="tooltip" data-bs-html="true" title="Wishlist"><i class="bi bi-heart"></i></a>
                                    </div>
                                </div>
                                <div class="text-small mb-1">
                                    <?php
                                    $category = new \Mini\Modules\contrib\dashboard\src\Modal\Category();
                                    $cate = $category->get($product->product_category)->getAt(0);
                                    ?>
                                    <a href="/shopping/products/<?= $cate->category_name; ?>" class="text-decoration-none text-muted"><small><?= $cate->category_name; ?></small></a>
                                </div>
                                <h2 class="fs-6"><a href="/shopping/product/<?= $product->product_id; ?>" class="text-inherit text-decoration-none"><?= $product->product_name; ?></a></h2>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <?php if($product->product_discount_price): ?>
                                            <span class="text-dark"><?= $product->product_discount_price ?></span>
                                            <span class="text-decoration-line-through text-muted"><?= $product->product_normal_price ?></span>
                                        <?php else: ?>
                                            <span class="text-dark"><?= $product->product_normal_price ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php
                                        $reviews = new \Mini\Modules\contrib\reviews\src\Plugin\Reviews();
                                        $rating = $reviews->getRatingAverage($product->product_id);
                                        $filled = array_fill(0,$rating,1);
                                        ?>
                                        <small class="text-warning">
                                            <?php for($i = 0; $i < 5; $i++): ?>
                                                <?php if(isset($filled[$i])): ?>
                                                    <i class="bi bi-star-fill" onclick="addRating(<?= $i ?>,<?= $product->product_id; ?>)"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-star" onclick="addRating(<?= $i ?>,<?= $product->product_id; ?>)"></i>
                                                <?php endif;
                                            endfor; ?>
                                        </small>
                                        <span><small><?= $rating; ?></small></span>
                                    </div>
                                </div>
                                <div class="d-grid mt-2">
                                    <a href="/shopping/product/<?= $product->product_id ?>/cart" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        Add to cart
                                    </a>
                                </div>
                                <div class="d-flex justify-content-start text-center mt-3">
                                    <div class="deals-countdown w-100" data-countdown="<?= (new DateTime('tomorrow'))->format('Y/m/d h:s:i'); ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

<!--    <section class="my-lg-14 my-8">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-6 col-lg-3">-->
<!--                    <div class="mb-8 mb-xl-0">-->
<!--                        <div class="mb-6"><img src="assets/images/icons/clock.svg" alt=""></div>-->
<!--                        <h3 class="h5 mb-3">10 minute grocery now</h3>-->
<!--                        <p>Get your order delivered to your doorstep at the earliest from FreshCart pickup stores near you.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6 col-lg-3">-->
<!--                    <div class="mb-8 mb-xl-0">-->
<!--                        <div class="mb-6"><img src="assets/images/icons/gift.svg" alt=""></div>-->
<!--                        <h3 class="h5 mb-3">Best Prices & Offers</h3>-->
<!--                        <p>Cheaper prices than your local supermarket, great cashback offers to top it off. Get best pricess & offers.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6 col-lg-3">-->
<!--                    <div class="mb-8 mb-xl-0">-->
<!--                        <div class="mb-6"><img src="assets/images/icons/package.svg" alt=""></div>-->
<!--                        <h3 class="h5 mb-3">Wide Assortment</h3>-->
<!--                        <p>Choose from 5000+ products across food, personal care, household, bakery, veg and non-veg & other categories.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6 col-lg-3">-->
<!--                    <div class="mb-8 mb-xl-0">-->
<!--                        <div class="mb-6"><img src="assets/images/icons/refresh-cw.svg" alt=""></div>-->
<!--                        <h3 class="h5 mb-3">Easy Returns</h3>-->
<!--                        <p>-->
<!--                            Not satisfied with a product? Return it at the doorstep & get a refund within hours. No questions asked-->
<!--                            <a href="#!">policy</a>-->
<!--                            .-->
<!--                        </p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
</main>