<main class="main-content-wrapper">
            <div class="container">
               <div class="row mb-8">
                  <div class="col-md-12">
                     <!-- pageheader -->
                     <div class="d-flex justify-content-between align-items-center">
                        <div>
                           <h2>Vendors</h2>
                           <!-- breacrumb -->
                           <nav aria-label="breadcrumb">
                              <ol class="breadcrumb mb-0">
                                 <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                 <li class="breadcrumb-item active" aria-current="page">Vendors</li>
                              </ol>
                           </nav>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row -->
               <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 g-lg-6">
                   <?php if(!empty($content['vendors'])): ?>
                     <?php foreach ($content['vendors'] as $vendor): ?>
                       <?php if($vendor instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                  <!-- col -->
                  <div class="col">
                     <!-- card -->
                     <div class="card border-0 text-center card-lg">
                        <div class="card-body p-6">
                           <div>
                              <!-- img -->
                              <img src="<?= \Mini\Modules\contrib\sellers\src\Modals\Vendor::vendorLogo($vendor->vendor_logo); ?>" alt="" class="rounded-circle icon-shape icon-xxl mb-6">
                              <!-- content -->
                              <h2 class="mb-2 h5"><a href="#!" class="text-inherit"><?= $vendor->vendor_name; ?></a></h2>
                              <div class="mb-2">Vendor ID: #<?= $vendor->vendor_id; ?></div>
                              <div><?= $vendor->vendor_email_address; ?></div>
                           </div>
                           <!-- meta content -->
                           <div class="row justify-content-center mt-8">
                              <div class="col">
                                 <div>Products Count</div>
                                 <h5 class="mb-0 mt-1"><?= \Mini\Modules\contrib\sellers\src\Modals\Vendor::vendorProductCount($vendor->vendor_id); ?></h5>
                              </div>
                              <div class="col">
                                 <div>Earning</div>
                                 <h5 class="mb-0 mt-1">$200.00</h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                         <?php endif; ?>
                      <?php endforeach; ?>
                   <?php endif; ?>
               </div>
            </div>
         </main>
