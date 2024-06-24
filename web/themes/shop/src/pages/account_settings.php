<?php

/**@var $settings \Mini\Modules\contrib\customers\src\Routes\AccountSetting|null**/
$settings = $content['settings'] ?? null;
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
                        <!-- nav item -->
                        <ul class="nav flex-column nav-pills nav-pills-dark">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/user/account/orders">
                                    <i class="feather-icon icon-shopping-bag me-2"></i>
                                    Your Orders
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link active" href="/user/account/settings">
                                    <i class="feather-icon icon-settings me-2"></i>
                                    Settings
                                </a>
                            </li>
                            <!-- nav item -->
                            <li class="nav-item">
                                <a class="nav-link" href="/user/account/address">
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
                                <a class="nav-link" href="../index.html">
                                    <i class="feather-icon icon-log-out me-2"></i>
                                    Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="py-6 p-md-6 p-lg-10">
                        <div class="mb-6">
                            <!-- heading -->
                            <h2 class="mb-0">Account Setting</h2>
                        </div>
                        <div>
                            <!-- heading -->
                            <h5 class="mb-4">Account details</h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <!-- form -->
                                    <form method="post" enctype="multipart/form-data" class="row">
                                        <!-- input -->
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First Name</label>
                                            <input id="firstname" value="<?= $settings?->getFirstName() ?>" name="firstname" type="text" class="form-control" placeholder="firstname">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input id="lastname" value="<?= $settings?->getLastName() ?>" name="lastname" type="text" class="form-control" placeholder="lastname">
                                        </div>
                                        <!-- input -->
                                        <div class="mb-3">
                                            <label for="profile" class="form-label">Profile image</label>
                                            <input id="profile" name="profile" type="file" class="form-control" placeholder="profile">
                                        </div>
                                        <div class="mb-5">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input id="phone" name="phone" type="text" class="form-control" placeholder="Phone number">
                                        </div>
                                        <!-- button -->
                                        <div class="mb-3">
                                            <button name="normal_update" class="btn btn-primary">Save Details</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-2">
                                    <img alt="<?= $settings->getAccountName() ?>" src="<?= $settings->getImage(); ?>" class="thumbnails-img w-100 rounded">
                                </div>
                            </div>
                        </div>
                        <hr class="my-10">
                        <div class="pe-lg-14">
                            <!-- heading -->
                            <h5 class="mb-4">Password</h5>
                            <form method="post" class="row row-cols-1 row-cols-lg-2">
                                <!-- input -->
                                <div class="mb-3 col">
                                    <label class="form-label">New Password</label>
                                    <input name="new_password" type="password" class="form-control" placeholder="**********">
                                </div>
                                <!-- input -->
                                <div class="mb-3 col">
                                    <label class="form-label">Current Password</label>
                                    <input name="current_password" type="password" class="form-control" placeholder="**********">
                                </div>
                                <!-- input -->
                                <div class="col-12">
                                    <p class="mb-4">
                                        Can’t remember your current password?
                                        <a href="/user/password">Reset your password.</a>
                                    </p>
                                    <input type="submit" name="password_change" class="btn btn-primary" value="Save Password">
                                </div>
                            </form>
                        </div>
                        <hr class="my-10">
                        <div>
                            <!-- heading -->
                            <h5 class="mb-4">Delete Account</h5>
                            <p class="mb-2">Would you like to delete your account?</p>
                            <p class="mb-5">This account contain 12 orders, Deleting your account will remove all the order details associated with it.</p>
                            <!-- btn -->
                            <a href="#" class="btn btn-outline-danger">I want to delete my account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
