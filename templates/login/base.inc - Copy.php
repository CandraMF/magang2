<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg">
<head>
    <meta charset="utf-8" />
     <title> <!--JudulApp--></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
	<link rel="shortcut icon" href="{BaseUrl}/favicon-bpkh.png">

    <!-- Layout config Js -->
    <script src="{BaseUrl}/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{BaseUrl}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{BaseUrl}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{BaseUrl}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{BaseUrl}/assets/css/custom.min.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="{BaseUrl}/assets/images/logo-light.png" alt="" height="30">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium"> SISTEM INFORMASI LAYANAN HUKUM</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Selamat Datang !</h5>
                                    <p class="text-muted">Login Untuk Masuk Ke SILAKUM.</p>
                                </div>
                                <div class="p-2 mt-4">
									<form action='{BaseMain}'  method="post" id='FmLogin' name='FmLogin' >

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="uLogin" placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">
                                         
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5"  name='pLogin' placeholder="Enter password" id="password-input">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                     

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Masuk</button>
                                        </div>
										<input type="hidden" name="uTahun" value='2022'>
										<input type="hidden" name="Pg" value='login' >
										<input type="hidden" name='uToken' value="{--utoken--}"/>
										
										<input type="hidden" name='ScreenHeight' />
										<input type="hidden" name='ScreenWidth' />
										<script>
											FmLogin.ScreenHeight.value=window.screen.availHeight;
											FmLogin.ScreenWidth.value=window.screen.availWidth;
										</script>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
							
                        </div>
                        <!-- end card -->

                       <center><img src="{BaseUrl}/images/bpkh.png" height='40px;' align=center>
</center>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted" style='color: #666;text-shadow: 0px 1px 0px rgba(0,0,0,.5); /* 50% black coming from the bottom */'> 
								BPKH RI | 2022
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{BaseUrl}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{BaseUrl}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{BaseUrl}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{BaseUrl}/assets/libs/feather-icons/feather.min.js"></script>
    <script src="{BaseUrl}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{BaseUrl}/assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="{BaseUrl}/assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="{BaseUrl}/assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="{BaseUrl}/assets/js/pages/password-addon.init.js"></script>
</body>


</html>