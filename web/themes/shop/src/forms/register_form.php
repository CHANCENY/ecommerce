<main>
    <!-- section -->

    <section class="my-lg-14 my-8">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                    <!-- img -->
                    <img src="/themes/shop/assets/images/svg-graphics/signup-g.svg" alt="" class="img-fluid">
                </div>
                <!-- col -->
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                    <div class="mb-lg-9 mb-5">
                        <h1 class="mb-1 h2 fw-bold">Get Start Shopping</h1>
                        <p>Welcome to FreshCart! Enter your email to get started.</p>
                    </div>
                    <!-- form -->
                    <form method="post" class="needs-validation" novalidate="">
                        <div class="row g-3">
                            <!-- col -->
                            <div class="col">
                                <!-- input -->
                                <label for="formSignupfname" class="form-label visually-hidden">First Name</label>
                                <input name="firstname" type="text" class="form-control" id="formSignupfname" placeholder="First Name" required="">
                                <div class="invalid-feedback">Please enter first name.</div>
                            </div>
                            <div class="col">
                                <!-- input -->
                                <label for="formSignuplname" class="form-label visually-hidden">Last Name</label>
                                <input name="lastname" type="text" class="form-control" id="formSignuplname" placeholder="Last Name" required="">
                                <div class="invalid-feedback">Please enter last name.</div>
                            </div>
                            <div class="col-12">
                                <div class="col">
                                    <!-- input -->
                                    <label for="formSignupuname" class="form-label visually-hidden">User Name</label>
                                    <input name="username" type="text" class="form-control" id="formSignupuname" placeholder="User Name" required="">
                                    <div class="invalid-feedback">Please enter username.</div>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <!-- input -->
                                    <label for="formSignuploname" class="form-label visually-hidden">Profile Image</label>
                                    <input name="image" type="file" class="form-control" id="formSignuploname" placeholder="Profile Image" required="">
                                    <div class="invalid-feedback">Please enter profile image.</div>
                                </div>
                                <div class="col">
                                    <!-- input -->
                                    <label for="formSignuprole" class="form-label visually-hidden">Role</label>
                                    <select name="role" id="formSignuprole" class="form-control">
                                        <option value="authenticated" selected>Authenticated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- input -->
                                <label for="formSignupEmail" class="form-label visually-hidden">Email address</label>
                                <input name="email" type="email" class="form-control" id="formSignupEmail" placeholder="Email" required="">
                                <div class="invalid-feedback">Please enter email.</div>
                            </div>
                            <div class="col-12">
                                <div class="password-field position-relative">
                                    <label for="formSignupPassword" class="form-label visually-hidden">Password</label>
                                    <div class="password-field position-relative">
                                        <input name="password" type="password" class="form-control fakePassword" id="formSignupPassword" placeholder="*****" required="">
                                        <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                                        <div class="invalid-feedback">Please enter password.</div>
                                    </div>
                                </div>
                                <div class="password-field position-relative mt-2">
                                    <label for="formSignupPasswordConfirm" class="form-label visually-hidden">Password</label>
                                    <div class="password-field position-relative">
                                        <input name="confirm" type="password" class="form-control fakePassword" id="formSignupPasswordConfirm" placeholder="*****" required="">
                                        <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                                        <div class="invalid-feedback">Please enter confirm password.</div>
                                    </div>
                                </div>
                            </div>
                            <!-- btn -->
                            <div class="col-12 d-grid"><input value="Register" name="user" type="submit" class="btn btn-primary"></div>

                            <!-- text -->
                            <p>
                                <small>
                                    By continuing, you agree to our
                                    <a href="#!">Terms of Service</a>
                                    &
                                    <a href="#!">Privacy Policy</a>
                                </small>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
