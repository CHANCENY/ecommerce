<main class="main-content-wrapper">
    <div class="container">
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <div>
                        <h2>Customers</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Customers</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="/user/register" class="btn btn-primary">Add New Customer</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-12 mb-5">
                <div class="card h-100 card-lg">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table datatable table-centered table-hover table-borderless mb-0 table-with-checkbox text-nowrap">
                                <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th>Spent</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($content['customers'])): foreach ($content['customers'] as $customer): ?>
                                    <?php if($customer instanceof \Mini\Cms\Entities\User && !empty($customer->getUid())): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $customer->getImage(); ?>" alt="" class="avatar avatar-xs rounded-circle">
                                                <div class="ms-2">
                                                    <a href="/user/<?= $customer->getUid(); ?>" class="text-inherit"><?= $customer->getFirstname(). ' '.$customer->getLastname(); ?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $customer->getEmail(); ?></td>
                                        <td><?= date('F d, Y',$customer->getCreated()); ?></td>
                                        <td><?= \Mini\Modules\contrib\customers\src\Plugin\Customers::getCustomerSpending($customer->getUid(), (new \Mini\Cms\Modules\CurrentUser\CurrentUser())->id()); ?></td>
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
