<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Petugas</title>
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
          <a class="nav-link" href="<?= site_url('DataPetugas') ?>"><span class="oi oi-person"></span> Data Petugas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataStasiun") ?>"><span class="oi oi-vertical-align-center"></span> Data Stasiun</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataRute") ?>"><span class="oi oi-map-marker"></span> Data Rute</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataKontainer") ?>"><span class="oi oi-hard-drive"></span> Data Kontainer</a>
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
              <a class="" href="<?php echo site_url("DataPetugas") ?>"><span class="oi oi-people"></span> Data Petugas</a>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("DataStasiun") ?>"><span class="oi oi-vertical-align-center"></span> Data Stasiun</a>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("DataRute"); ?>"><span class="oi oi-map-marker"></span> Data Rute</a>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("DataKontainer") ?>"><span class="oi oi-hard-drive"></span> Data Kontainer</a>
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
                    <th scope="col">Stasiun</th>
                    <th scope="col">Password</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users  as $row): ?>
                    <?php echo '<tr>' ?>
                      <?php echo '<th scope="row">'.$row->id.'</th>' ?>
                      <?php echo '<td>'.$row->username.'</td>' ?>
                      <?php echo '<td>'.$row->nama.'</td>' ?>
                      <?php echo '<td>'.$row->id_stasiun.'</td>' ?>
                      <?php echo '<td>'.$row->password.'</td>' ?>
                      <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" onclick="edit(<?= $row->id ?>)" data-target="#modalEdit">
                          Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="hapus(<?= $row->id ?>)" data-target="#modalHapus">
                          Hapus
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>

                  <script type="text/javascript">
                  function edit(id) {
                    $.ajax({
                      type : "GET",
                      url  : "<?php echo site_url("DataPetugas/get_user")?>",
                      dataType : "JSON",
                      data : {id:id},
                      success: function(data){
                        $.each(data,function(id, username, nama, id_stasiun, password){
                          // $('#ModalaEdit').modal('show');
                          $('[name="id_edit"]').val(data.id);
                          $('[name="username_edit"]').val(data.username);
                          $('[name="nama_edit"]').val(data.nama);
                          $('[name="stasiun_edit"]').val(data.id_stasiun);
                          $('[name="password_edit"]').val(data.password);
                        });
                      }
                    });
                  }
                  function hapus(id) {
                    $('[name="id_hapus"]').val(id);
                  }
                  function tambah() {
                    var username =  $("input[name=username]").val();
                    var nama = $("input[name=nama]").val();
                    var password = $("input[name=password]").val();
                    if (username===""||nama===""||password==="") {
                      element = document.getElementById('pesan_tambah');
                      element.removeAttribute("style");
                    } else {
                      document.forms["tambah"].submit();
                    }
                  }
                  function update() {
                    var username =  $("input[name=username_edit]").val();
                    var nama = $("input[name=nama_edit]").val();
                    var password = $("input[name=password_edit]").val();
                    if (username===""||nama===""||password==="") {
                      element = document.getElementById('pesan_edit');
                      element.removeAttribute("style");
                    } else {
                      document.forms["edit"].submit();
                    }
                  }
                  </script>

                </tbody>
              </table>
            </div><!--table-responsive-->
          </div>

          <!-- Modal tambah-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="tambah" action="<?= site_url("DataPetugas/insert"); ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="pesan_tambah" class="alert alert-danger" style="display:none" role="alert">
                      Harap isi semua data
                    </div>
                    <div class="form-group row">
                      <label for="username" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="username" placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="stasiun" class="col-sm-2 col-form-label">Stasiun</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="stasiun" id="stasiun">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun ?> (<?= $row->kota ?>)</option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="password" id="password" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="tambah()" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal tambah-->
          <!-- Modal Edit-->
          <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="edit" action="<?php echo site_url("DataPetugas/update") ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="pesan_edit" class="alert alert-danger" style="display:none" role="alert">
                      Harap isi semua data
                    </div>
                    <input type="hidden" name="id_edit" value="">
                    <div class="form-group row">
                      <label for="username" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username_edit" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama_edit" placeholder="Nama">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="stasiun" class="col-sm-2 col-form-label">Stasiun</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="stasiun_edit" id="stasiun">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun ?> (<?= $row->kota ?>)</option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="password" name="password_edit" placeholder="Password">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="update()" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal Edit-->
          <!-- Modal Hapus-->
          <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?php echo site_url('DataPetugas/delete') ?>" method="get">
                  <div class="modal-body">
                    <input type="hidden" name="id_hapus" value="">
                    Anda yakin ingin menghapus?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal Hapus-->
        </div> <!-- col-md-10-->
      </div> <!-- row -->
    </body>
    </html>
