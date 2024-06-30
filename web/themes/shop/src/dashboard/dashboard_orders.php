<!-- main wrapper -->
<main class="main-content-wrapper">
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <!-- page header -->
                <div>
                    <h2>Order List</h2>
                    <!-- breacrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order List</li>
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
                        <div class="row justify-content-between">
                            <div class="col-md-4 col-12 mb-2 mb-md-0">

                            </div>
                            <div class="col-lg-2 col-md-4 col-12">
                                <!-- select -->
                                <select id="actions" class="form-select">
                                    <option selected="">Status</option>
                                    <option value="1">Confirmed</option>
                                    <option value="2">Shipping</option>
                                    <option value="3">Delivered</option>
                                    <option value="4">Cancel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- card body -->
                    <div class="card-body p-0">
                        <!-- table responsive -->
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
                                    <th>Order Name</th>
                                    <th>Customer</th>
                                    <th>Date & TIme</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($content['orders'])): ?>
                                  <?php foreach ($content['orders'] as $order): ?>
                                    <?php if($order instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                                     <?php
                                        $user = \Mini\Cms\Entities\User::load($order->order_by);
                                        $created = (new DateTime($order->customer_orders_created))->format('d F, Y (H:i A)');
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input data="<?= $order->order_id ?>" class="form-check-input checkboxes" type="checkbox" value="" id="orderOne">
                                                        <label class="form-check-label" for="orderOne"></label>
                                                    </div>
                                                </td>
                                                <td><a href="/shop/orders/<?= $order->common_id ?>" class="text-reset">#<?= $order->common_id ?? null; ?></a></td>
                                                <td><?= $user->getFirstname() .' '. $user->getLastname(); ?></td>

                                                <td><?= $created ?></td>
                                                <td>Paypal</td>

                                                <td>
                                                    <?php if($order->order_status === 0): ?>
                                                        <span class="badge bg-light-warning text-dark-warning">Pending</span>
                                                    <?php elseif($order->order_status === 1): ?>
                                                        <span class="badge bg-light-primary text-dark-primary">Confirmed</span>
                                                    <?php elseif($order->order_status === 2): ?>
                                                        <span class="badge bg-light-info text-dark-info">Shipping</span>
                                                    <?php elseif($order->order_status === 3): ?>
                                                        <span class="badge bg-light-primary text-dark-primary">Delivered</span>
                                                    <?php elseif ($order->order_status === 4): ?>
                                                        <span class="badge bg-light-danger text-dark-danger">Cancel</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $order->amount ?? 0; ?></td>
                                            </tr>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                                <?php endif; ?>
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
                    actions.push({order_id: item.getAttribute('data'), status: e.target.value})
                }
            });
            if(actions) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/shop/orders',true);
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