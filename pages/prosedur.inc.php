<?php
	$Main->Isi="
		<body id='kt_body' data-sidebar='on' class='header-fixed header-tablet-and-mobile-fixed sidebar-enabled'>
  <div class='d-flex flex-column mb-10'>
    <div class='d-flex flex-row flex-column-fluid'>
      <div class='d-flex flex-column flex-row-fluid'>
        <div id='kt_header' class='header'>
          <div class='container d-flex align-items-stretch justify-content-between px-0'>
            <div class='d-flex align-items-center'>
              <img src='logo-bpkh-s.png' alt='' srcset='' style='width: 130px;'>
            </div>
            <div class='d-flex align-items-center'>
              <a href='{$Url->BaseMain}/home/' class='btn btn-active-success ms-1'>
                Beranda
              </a>
              <a href='{$Url->BaseMain}/prosedur/' class='active btn btn-active-success ms-1'>
                Informasi Magang
              </a>
              <a href='{$Url->BaseMain}/daftar/' class='btn btn-active-success ms-1'>
                Daftar
              </a>
              <a href='{$Url->BaseMain}/masuk/' class=' btn btn-bg-warning btn-active-success ms-1'>
                Masuk
              </a>
            </div>
          </div>
        </div>
        <div class='d-flex flex-column flex-column-fluid min-vh-100'>
          <div class='container-fluid'>
            <div class='d-flex flex-column pt-10 flex-md-row px-10'>
              <div class='flex-column flex-md-row-auto w-100 w-md-250px w-xxl-350px'>
                <div class='card mb-10 mb-md-0'>
                  <div class='card-body py-10 px-6'>
                    <div class='d-flex flex-column mb-10 px-3'>
                      <form>
                        <div class='input-group input-group-solid' id='kt_chat_aside_search'>
                          <span class='input-group-text' id='basic-addon1'>
                            <span class='svg-icon svg-icon-1 svg-icon-dark'>
                              <inline-svg src='/media/icons/duotone/general/gen004.svg' />
                            </span>
                          </span>
                          <input type='text' class='form-control ps-0 py-4 h-auto' placeholder='Cari' />
                        </div>
                      </form>
                    </div>

                    <ul
                      class='menu menu-column menu-rounded menu-gray-600 menu-hover-bg-light-primary menu-active-bg-light-primary fw-bold mb-10'>
                      <li class='menu-content fw-bold pb-2 px-3'>
                        <span class='fs-3 fw-bolder'>Prosedur</span>
                      </li>
                      <li class='menu-item px-3 pb-1'>
                        <a href='prosedur-magang-pendaftaran.html' class='menu-link fs-6 px-3'>
                          Prosedur Pendaftaran
                        </a>
                      </li>
                      <li class='menu-item px-3 pb-1'>
                        <a href='prosedur-magang.html' class='menu-link fs-6 px-3'>
                          Prosedur Magang
                        </a>
                      </li>
                      <li class='menu-item px-3 pb-1'>
                        <a href='prosedur-magang-hari-kerja.html' class='menu-link fs-6 px-3'>
                          Hari dan Jam Kerja
                        </a>
                      </li>
                    </ul>

                    <ul
                      class='menu menu-column menu-rounded menu-gray-600 menu-hover-bg-light-primary menu-active-bg-light-primary fw-bold mb-10'>
                      <li class='menu-content fw-bold pb-2 px-3'>
                        <span class='fs-3 fw-bolder'>Aturan Dasar</span>
                      </li>
                      <li class='menu-item px-3 pb-1'>
                        <a href='prosedur-magang-absensi.html' class='active menu-link fs-6 px-3'>
                          Absensi
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class='flex-md-row-fluid ms-md-12'>
                <div class='card'>
                  <div class='card-body py-10'>
                    <h3 class='text-dark fw-bolder fs-1 mb-5'>Absensi</h3>
                  </div>
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
  <script src='assettemp/assets/plugins/global/plugins.bundle.js'></script>
  <script src='assettemp/assets/js/scripts.bundle.js'></script>
</body>

	";
?>