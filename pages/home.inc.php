<?php
	$Main->Isi="
		<body id='kt_body' data-sidebar='on' class='header-fixed header-tablet-and-mobile-fixed sidebar-enabled'>
  <div class='d-flex flex-column'>
    <div class='d-flex flex-row flex-column-fluid'>
      <div class='d-flex flex-column flex-row-fluid'>
        <div id='kt_header' class='header'>
          <div class='container d-flex align-items-stretch justify-content-between px-0'>
            <div class='d-flex align-items-center'>
              <img src='logo-bpkh-s.png' alt='' srcset='' style='width: 130px;'>
            </div>
            <div class='d-flex align-items-center'>
              <a href='{$Url->BaseMain}/home/' class='active btn btn-active-success ms-1'>
                Beranda
              </a>
              <a href='{$Url->BaseMain}/prosedur/' class=' btn btn-active-success ms-1'>
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
        <div class='d-flex flex-column flex-column-fluid'>
          <div class='d-flex flex-column-fluid' id='kt_content'>
            <div class='container text-center px-0'>
              <div class='my-5'>
                <h1 class='text-white fs-2hx' style='color: #123155 !important;'>
                  <span class='fw-normal'>Selamat Datang di </span> <span class='fw-bolder'>Portal Magang BPKH</span>
                </h1>
                <div class='d-flex flex-column align-items-center justify-content-center'>
                  <div class='col-md-7 mb-5 pb-5'>
                    <form action=''>
                      <div class='inner-form'>
                        <div class='search-field'>
                          <button class='btn-search-logo' type='button'>
                            <svg xmlns='http://www.w3.org/2000/svg' fill='#525252' width='24' height='24'
                              viewBox='0 0 24 24'>
                              <path
                                d='M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z'>
                              </path>
                            </svg>
                          </button>
                          <input id='search' type='text' autofocus placeholder='Cari Posisi Magang' />
                          <button class='btn-search'>
                            Cari
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class='py-5'>
                <div class='card bg-white mt-5 px-10 rounded-3'>
                  <div class='col-md-12 d-flex justify-content-center p-10'>
                    <div class='row py-10'>
                      <div class='col-md-4 mb-5 text-center '>
                        <a href='/detail/Administrasi Keuangan' class='nav-link text-dark'>
                          Administrasi Keuangan
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Manajemen Resiko Bisnis' class='nav-link text-dark'>
                          Manajemen Resiko Bisnis
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Administrasi Kantor' class='nav-link text-dark'>
                          Administrasi Kantor
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Pengadaan' class='nav-link text-dark'>
                          Pengadaan
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/ILAL' class='nav-link text-dark '>
                          <div class='position-relative d-inline-block'>
                            <span>ILAL</span>
                          </div>
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Humas' class='nav-link text-dark'>
                          Humas
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Perencanaan' class='nav-link text-dark'>
                          Perencanaan
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Kepatuhan' class='nav-link text-dark'>
                          Kepatuhan
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Teknologi Informasi' class='nav-link text-dark'>
                          Teknologi Informasi
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>

                        <a href='/detail/Registrasi dan Analisa Kemaslahatan' class='nav-link text-dark'>

                          <div class='position-relative '>
                            <span>
                              Registrasi dan Analisa Kemaslahatan
                              <span class='position-absolute badge badge-light-success'
                                style='right: -25px; top: -15px;'>Dibuka</span>
                            </span>
                          </div>

                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Administrasi Sekretariat Kepala' class='nav-link text-dark'>
                          Administrasi Sekretariat Kepala
                        </a>
                      </div>
                      <div class='col-md-4 mb-5 text-center'>
                        <a href='/detail/Manajemen Risiko Korporat' class='nav-link text-dark'>
                          Manajemen Risiko Korporat
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class='my-5 py-5'>
                <div class='col-md-12'>
                  <div class='row'>
                    <div class='col-md-11'>
                      <div class='row text-start'>
                        <div class='col-md-4'>
                          <div class='card berita-card overlay overflow-hidden my-2 my-md-0 my-lg-0 my-xl-0'
                            title='Daftar Nama Peserta Lolos Seleksi Tahap 1'>
                            <div class='card-body'>
                              <div class='overlay-wrapper'>
                                <!-- <el-skeleton :rows='2' animated /> -->
                                <h4 class='cut-text'>Daftar Nama Peserta Lolos Seleksi Tahap 1</h4>
                                <span class='text-gray-400 fs-6 fw-bold pe-2'>5 Oktober 2022</span>
                              </div>
                              <div class='overlay-layer bg-dark bg-opacity-10'>
                                <a href='#' class='btn btn-primary btn-shadow'>Lihat</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class='col-md-4'>
                          <div class='card berita-card overlay overflow-hidden my-2 my-md-0 my-lg-0 my-xl-0'
                            title='Pembukaan Lowongan Magang Batch 3, Apa Saja Posisi Magang yang di Buka?'>
                            <div class='card-body'>
                              <div class='overlay-wrapper'>
                                <!-- <el-skeleton :rows='2' animated /> -->
                                <h4 class='cut-text'>Pembukaan Lowongan Magang Batch 3, Apa Saja Posisi Magang yang di
                                  Buka?</h4>
                                <span class='text-gray-400 fs-6 fw-bold pe-2'>5 Oktober 2022</span>
                              </div>
                              <div class='overlay-layer bg-dark bg-opacity-10'>
                                <a href='#' class='btn btn-primary btn-shadow'>Lihat</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class='col-md-4'>
                          <div class='card berita-card overlay overflow-hidden my-2 my-md-0 my-lg-0 my-xl-0'
                            title='Daftar Nama Peserta Lolos Seleksi Tahap 1'>
                            <div class='card-body'>
                              <div class='overlay-wrapper'>
                                <!-- <el-skeleton :rows='2' animated /> -->
                                <h4 class='cut-text'>Daftar Nama Peserta Lolos Seleksi Tahap 1</h4>
                                <span class='text-gray-400 fs-6 fw-bold pe-2'>5 Oktober 2022</span>
                              </div>
                              <div class='overlay-layer'>
                                <a href='#' class='btn btn-primary btn-shadow'>Lihat</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='col-md-1 text-start'>
                        <div to='/pengumuman' class='btn btn-success h-100 my-md-0 my-lg-0 my-xl-0' style='width: 100%;'>
                          <div class='d-flex h-100 align-items-center justify-content-center'>
                            <span><i class='bi bi-chevron-right text-white fs-2'></i></span>
                          </div> 
                        </div> 
                    </div>
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
    <div id='kt_docs_example_basic' class='btn btn-primary position-fixed m-5' data-kt-scrolltop='true' style='z-index: 9999; right: 0; bottom: 0;'>
      <i class='fa fa-chevron-up fs-4'></i>
    </div>
  </footer>
  <script src='assettemp/assets/plugins/global/plugins.bundle.js'></script>
  <script src='assettemp/assets/js/scripts.bundle.js'></script>
</body>
	";
?>