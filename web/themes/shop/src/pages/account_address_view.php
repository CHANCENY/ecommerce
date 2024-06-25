<?php

use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Cms\Modules\Respositories\Territory\Country;
use Mini\Cms\Modules\Respositories\Territory\State;

/**@var $address RecordCollection|null **/

$address = $content['address'] ?? null;

$address_field = $content['address_field'] ?? null;

/**@var $country Country **/
$country = $content['country'] ?? null;

/**@var $state State **/
$state = $content['state'] ?? null;

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
                            <h2 class="mb-0">Address: <?= $address->address_type ?? null; ?></h2>
                        </div>
                        <div class="row">
                            <div class="col-xl-5 col-lg-6 col-xxl-4 col-12 mb-4">
                                <div class="card ps-2">
                                    <p class="mb-6">

                                        <?= $address->firstname. ' '. $address->lastname ?>
                                        <br>

                                        <?= $content['more']['address_1'] ?>,
                                        <br>

                                        <?= $state->getName().', '.$country->getName().', '.$content['more']['zip_code'] ?? null;  ?>
                                        <br>

                                        <?= $address->phone_number; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-6 col-xxl-4 col-12 mb-4">
                                <div class="card ps-2">
                                    <?= $content['address_field'] ?? null; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

