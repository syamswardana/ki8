<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
  </head>
  <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-orange">
        <a class="navbar-brand" href="#">
          <img src="<?= base_url(); ?>assets/images/logo.png" width="30" height="30" alt="">
          Karya Indah Delapan
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto " id="menu">
            <li class="nav-item active">
              <a class="nav-link" href="#"><span class="oi oi-person"></span> Data Petugas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url("/dashboard") ?>">Data Barang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url("/datastasiun") ?>">Data Stasiun</a>
            </li>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url("dashboard/data_kontainer") ?>">Data Kontainer</a>
            </li>
          </ul>
          <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="oi oi-person"></span> <?php echo $this->session->userdata('name'); ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">Logout</a>
            </div>
      </nav>
      <div class="row" style="height:100%;margin:0;">

          <div class="col-md-2 d-none d-sm-block" id="sidebar">
            <ul class="" id="menu-sidebar">
              <li class="sidebar-list active">
                <a class="" href="<?php echo site_url("/dashboard") ?>"><span class="oi oi-people"></span> Data Petugas</a>
              </li>
              <li class="sidebar-list">
                <a class="" href="#"><span class="oi oi-vertical-align-center"></span> Data Stasiun</a>
              </li>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("dashboard/data_kontainer") ?>"><span class="oi oi-hard-drive"></span> Data Kontainer</a>
            </li>
          </ul>
        </div>
        <div class="col-md-10">
          <!-- Button trigger modal -->
          <div class="container" id="main">
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
              Tambah
            </button>
            <br><br>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Password</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>syams</td>
                    <td>Syams Rachman</td>
                    <td>123456</td>
                    <td>
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">
                        Edit
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus">
                        Hapus
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>mifta</td>
                    <td>Miftahul Hasanah</td>
                    <td>123456</td>
                    <td>
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">
                        Edit
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus">
                        Hapus
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>Larry Lobster</td>
                    <td>123456</td>
                    <td>
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit">
                        Edit
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus">
                        Hapus
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div><!--table-responsive-->
          </div>

          <!-- Modal tambah-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="" action="index.html" method="post">
                    <div class="form-group row">
                      <label for="username" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" placeholder="Nama">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="password" placeholder="Password">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </div> <!--modal tambah-->
          <!-- Modal Edit-->
          <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Data Petugas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="" action="index.html" method="post">
                    <div class="form-group row">
                      <label for="username" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" placeholder="Nama">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="password" placeholder="Password">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="button" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </div> <!--modal Edit-->
          <!-- Modal Hapus-->
          <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  Anda yakin ingin menghapus?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-danger">Hapus</button>
                </div>
              </div>
            </div>
          </div> <!--modal Hapus-->
        </div> <!-- col-md-10-->
      </div> <!-- row -->
  </body>
</html>
