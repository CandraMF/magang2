<?php
	$Main->Isi="
		<body id='kt_body' data-sidebar='on' class='header-fixed header-tablet-and-mobile-fixed sidebar-enabled'>
  <div class='d-flex flex-column mb-10 min-vh-100'>
    <div class='d-flex flex-row flex-column-fluid'>
      <div class='d-flex flex-column flex-row-fluid'>
        <div id='kt_header' class='header'>
          <div class='container d-flex align-items-stretch justify-content-between px-0'>
            <div class='d-flex align-items-center'>
              <img src='logo-bpkh-s.png' alt='' srcset='' style='width: 130px;'>
            </div>
            <div class='d-flex align-items-center'>
              <a href='{$Url->BaseMain}/home/' class=' btn btn-active-success ms-1'>
                Beranda
              </a>
              <a href='{$Url->BaseMain}/prosedur/' class=' btn btn-active-success ms-1'>
                Informasi Magang
              </a>
              <a href='{$Url->BaseMain}/daftar/' class='active btn btn-active-success ms-1'>
                Daftar
              </a>
              <a href='{$Url->BaseMain}/masuk/' class=' btn btn-bg-warning btn-active-success ms-1'>
                Masuk
              </a>
            </div>
          </div>
        </div>
        <div class='d-flex flex-column flex-column-fluid'>
          <div class='row d-flex justify-content-center m-0 p-0'>
            <div class='col-md-6 mt-10'>
              <div class='card p-5'>
                <div class='card-header justify-content-start py-4'>
                  <h3>Registrasi Akun</h3>
                  <p class='text-info'>Pastikan Data yang Anda Masukkan Adalah Data yang Benar dan Valid</p>
                </div>
                <div class='card-body pt-10 pb-1'>
                  <el-form :model='ruleForm' :rules='rules' ref='ruleForm' label-position='top' status-icon>
                    <div class='col-md-12'>
                      <div class='row'>
                        <div class='col-md-6'>
                          <div class='mb-10'>
                            <label for='exampleFormControlInput1' class='required form-label'>Nomor Induk Kependudukan</label>
                            <input type='text' name='nik' class='form-control form-control-solid' placeholder='Masukkan NIK'/>
                          </div>
      
                          <div class='mb-10'>
                            <label for='exampleFormControlInput1' class='required form-label'>Nomor Ponsel</label>
                            <input type='text' name='no_hp' class='form-control form-control-solid' placeholder='Masukkan Nomor HP'/>
                          </div>
                        </div>
                        <div class='col-md-6'>
                          <div class='mb-10'>
                            <label for='exampleFormControlInput1' class='required form-label'>Nama Lengkap</label>
                            <input type='text' name='nama_lengkap' class='form-control form-control-solid' placeholder='Masukkan Nama Lengkap'/>
                          </div>
      
                          <div class='mb-10'>
                            <label for='exampleFormControlInput1' class='required form-label'>Email</label>
                            <input type='email' class='form-control form-control-solid' placeholder='Masukkan Email'/>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class='g-recaptcha' data-sitekey='your_site_key'></div>

                    <div class=' text-center mt-5 mb-5'>
                      <button type='submit' class='btn btn-success '>Daftar</button>
                      <div class='w-100 mb-5 mt-5'>Sudah Punya Akun? <a href='{$Url->BaseMain}/masuk/'>Masuk</a></div>
                    </div>
                  </el-form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class='mt-5' style='background: #092F53; color: white !important; padding: 25px 0px;'>
    <div class='text-center'>
      Hak Cipta &copy; 2022 Badan Pengelola Keuangan Haji <br>
      <div class='mt-5'>
        <a href='#' class='btn btn-icon btn-facebook me-5 '>
          <i class='fab fa-facebook-f fs-4'></i>
        </a>

        <a href='#' class='btn btn-icon btn-twitter me-5 '>
          <i class='fab fa-twitter fs-4'></i>
        </a>

        <a href='#' class='btn btn-icon btn-instagram me-5 '>
          <i class='fab fa-instagram fs-4'></i>
        </a>

        <a href='#' class='btn btn-icon btn-youtube me-5 '>
          <i class='fab fa-youtube fs-4'></i>
        </a>
      </div>
    </div>
  </footer>
  <script src='assets/plugins/global/plugins.bundle.js'></script>
  <script src='assets/js/scripts.bundle.js'></script>
  <script>
    grecaptcha.ready(function () {
      if (grecaptcha.getResponse() === '') {
        alert('Please validate the Google reCaptcha.');
      } else {
        alert('Successful validation! Now you can submit this form to your server side processing.');
      }
    });

  </script>
</body>

	";
?>