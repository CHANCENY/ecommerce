<main>
    <!-- section -->

    <section class="my-lg-14 my-8">
        <!-- container -->
        <div class="container">
            <div class="row">
                <!-- col -->
                <div class="offset-lg-2 col-lg-8 col-12">
                    <div class="mb-8">
                        <!-- heading -->
                        <h1 class="h3">Vendor Creation</h1>
                    </div>
                    <!-- form -->
                    <form method="post" enctype="multipart/form-data" class="row needs-validation" novalidate="">
                        <!-- input -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="contactFName">
                                Vendor Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="contactFName" class="form-control" name="vendor_name" placeholder="Enter Name" required="">
                            <div class="invalid-feedback">Please enter name.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- input -->
                            <label class="form-label" for="contactLName">
                                Vendor Phone
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="contactLName" class="form-control" name="vendor_phone_number" placeholder="Enter phone" required="">
                            <div class="invalid-feedback">Please enter phone number.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- input -->
                            <label class="form-label" for="contactCompanyName">
                                Vendor Logo
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" id="contactCompanyName" name="vendor_logo" class="form-control" placeholder="Logo" required="">
                            <div class="invalid-feedback">Please enter logo.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="contactEmail">
                                Vendor Email
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" id="contactEmail" name="vendor_email_address" class="form-control" placeholder="Enter email" required="">
                            <div class="invalid-feedback">Please enter email.</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <!-- input -->
                            <label class="form-label" for="contactTearea">Slogan</label>
                            <textarea name="vendor_slogan" rows="3" id="contactTearea" class="form-control" placeholder="Slogan" required=""></textarea>
                            <div class="invalid-feedback">Please enter a message in the slogan.</div>
                        </div>
                        <div class="col-md-12">
                            <!-- btn -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

