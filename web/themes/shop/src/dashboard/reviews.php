<main class="main-content-wrapper">
    <div class="container">
        <div class="row mb-8">
            <div class="col-md-12">
                <div>
                    <!-- page header -->
                    <h2>Reviews</h2>
                    <!-- breacrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-12 mb-5">
                <!-- card -->
                <div class="card h-100 card-lg">
                    <div class="p-6">

                    </div>
                    <!-- card body -->
                    <div class="card-body p-0">
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table datatable table-centered table-hover table-borderless mb-0 table-with-checkbox text-nowrap">
                                <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Reviews</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($content['reviews'])): foreach ($content['reviews'] as $review): ?>
                                  <?php if($review instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                                    <?php
                                        $user = \Mini\Cms\Entities\User::load($review->reviewer);
                                        $product = new \Mini\Modules\contrib\products\src\Modal\ProductModal();
                                        $prod = $product->get($review->product_id)->getAt(0);
                                        ?>
                                        <tr>
                                            <td><a href="/shop/review/<?= $review->review_id ?>" class="text-reset"><?= $prod->product_name; ?></a></td>
                                            <td><?= $user->getFirstname() .' '.$user->getLastname(); ?></td>

                                            <td>
                                                <span class="text-truncate"><?= substr($review->comment,0,60).'...'; ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php
                                                      $ratings = array_fill(0,$review->rating,1);
                                                    ?>
                                                    <?php for($i = 0; $i < 5; $i++): ?>
                                                       <?php if(isset($ratings[$i])): ?>
                                                            <span><i class="bi bi-star-fill text-warning"></i></span>
                                                       <?php else: ?>
                                                            <span><i class="bi bi-star-fill text-light"></i></span>
                                                       <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                            </td>
                                            <td><?= (new DateTime($prod->products_reviews_created))->format('d M, Y'); ?></td>
                                        </tr>
                                  <?php endif; ?>
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
