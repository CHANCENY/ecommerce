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
                            <li class="breadcrumb-item active" aria-current="page">Review</li>
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
                    <!-- card body -->
                    <div class="card-body p-0">
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table table-centered table-hover table-borderless mb-0 table-with-checkbox text-nowrap">
                                <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($content['review'])): $review = $content['review']; ?>
                                    <?php if($review instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                                        <?php
                                        $user = \Mini\Cms\Entities\User::load($review->reviewer);
                                        $product = new \Mini\Modules\contrib\products\src\Modal\ProductModal();
                                        $prod = $product->get($review->product_id)->getAt(0);
                                        ?>
                                        <tr>
                                            <td><?= $prod->product_name; ?></td>
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
                                            <td>
                                                <span class="text-truncate"><?= $review->comment; ?></span>
                                            </td>
                                        </tr>
                                    <?php endif; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
