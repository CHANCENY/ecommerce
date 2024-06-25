<?php


use Mini\Cms\Modules\CurrentUser\CurrentUser;

/**@var $user CurrentUser **/
$user = $content['current_user'] ?? null;

/**@var $countries array **/
$countries = $content['countries'] ?? null;

/**@var $states array **/
$states = $content['states'] ?? null;

?>
<main>
    <!-- section -->
    <section>
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center d-md-none py-4">
                        <!-- heading -->
                        <h3 class="fs-5 mb-0">Account Setting</h3>
                        <!-- button -->
                        <button class="btn btn-outline-gray-400 text-muted d-md-none btn-icon btn-sm ms-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount">
                            <i class="bi bi-text-indent-left fs-3"></i>
                        </button>
                    </div>
                </div>
                <!-- col -->
                <div class="col-lg-3 col-md-4 col-12 border-end d-none d-md-block">
                    <div class="pt-10 pe-lg-10">
                        <!-- nav -->
                        <ul class="nav flex-column nav-pills nav-pills-dark">
                            <!-- nav item -->
                            <li class="nav-item">
                                <!-- nav link -->
                                <a class="nav-link" aria-current="page" href="/user/account/orders">
                                    <i class="feather-icon icon-shopping-bag me-2"></i>
                                    Your Orders
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/user/account/settings">
                                    <i class="feather-icon icon-settings me-2"></i>
                                    Settings
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link active" href="/user/account/address">
                                    <i class="feather-icon icon-map-pin me-2"></i>
                                    Address
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/user/account/payments-method">
                                    <i class="feather-icon icon-credit-card me-2"></i>
                                    Payment Method
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/user/account/notification">
                                    <i class="feather-icon icon-bell me-2"></i>
                                    Notification
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <hr>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/user/logout">
                                    <i class="feather-icon icon-log-out me-2"></i>
                                    Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="py-6 p-md-6 p-lg-10">
                        <div class="d-flex justify-content-between mb-6">
                            <!-- heading -->
                            <h2 class="mb-0">Address</h2>

                        </div>
                        <div class="row">
                            <form method="post" class="row g-3">
                                <!-- col -->
                                <div class="col-12">
                                    <!-- input -->
                                    <input name="firstname" value="<?= $user->getFirstName(); ?>" type="text" class="form-control" placeholder="First name" aria-label="First name" required="">
                                </div>
                                <!-- col -->
                                <div class="col-12">
                                    <!-- input -->
                                    <input type="text" name="lastname" value="<?= $user->getLastName(); ?>" class="form-control" placeholder="Last name" aria-label="Last name" required="">
                                </div>
                                <div class="col-12">
                                    <!-- input -->
                                    <input type="text" name="phone_number" value="" class="form-control" placeholder="phone number" aria-label="Last name" required="">
                                </div>
                                <div class="col-12">
                                    <!-- form select -->
                                    <select name="address_type" class="form-select" required>
                                        <option value="home" selected>Home</option>
                                        <option value="work">Work</option>
                                        <option value="friend">Friend</option>
                                    </select>
                                </div>
                                <!-- col -->
                                <div class="col-12">
                                    <?php echo $content['address_field'] ?? null; ?>
                                </div>

                                <!-- col -->
                                <div class="col-12 mt-3">
                                    <!-- form check -->
                                    <div class="form-check">
                                        <input name="is_default" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Set as Default</label>
                                    </div>
                                </div>
                                <!-- col -->
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit" name="address_update">Save Address</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
