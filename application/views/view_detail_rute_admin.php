<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Detail Rute</title>
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
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataPetugas") ?>"><span class="oi oi-person"></span> Data Petugas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataStasiun") ?>"><span class="oi oi-vertical-align-center"></span> Data Stasiun</a>
        </li>
        <li class="nav-item active">
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
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("DataPetugas") ?>"><span class="oi oi-people"></span> Data Petugas</a>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("DataStasiun"); ?>"><span class="oi oi-vertical-align-center"></span> Data Stasiun</a>
            </li>
            <li class="sidebar-list active">
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
            <h3><?="Detail rute ".$id ?></h3>
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
              Tambah Stasiun
            </button>
            <br><br>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Urutan Stasiun</th>
                    <th scope="col">Nama Stasiun</th>
                    <th scope="col">Control</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $nomer = 1; ?>
                  <?php foreach ($urutan as $row): ?>
                    <tr>
                      <th scope="row"><?= $nomer ?></th>
                      <td><?= $row['nama_stasiun'] ?></td>
                      <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" onclick="edit(<?= $row['id'].",".$row['id_stasiun'] ?>)" data-target="#modalEdit">
                          Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" onclick="hapus(<?= $row['id'] ?>)" data-target="#modalHapus">
                          Hapus
                        </button>
                      </td>
                    </tr>
                  <?php $nomer+=1; ?>
                  <?php endforeach; ?>

                  <script type="text/javascript">
                  function edit(id,id_stasiun) {
                    $('[name="id_edit"]').val(id);
                    $('[name="stasiun_edit"]').val(id_stasiun);
                  }
                  function hapus(id) {
                    $('[name="id_hapus"]').val(id);
                  }
                  function tambah() {
                    // let rute =  $("input[name=rute]").val();
                    // if (rute==="") {
                    //   element = document.getElementById('pesan_tambah');
                    //   element.removeAttribute("style");
                    // } else {
                    //   document.forms["tambah"].submit();
                    // }
                      document.forms["tambah"].submit();


                  }
                  function update() {
                    // let rute =  $("input[name=rute_edit]").val();
                    // if (rute==="") {
                    //   element = document.getElementById('pesan_edit');
                    //   element.removeAttribute("style");
                    // } else {
                    // }
                    document.forms["edit"].submit();
                  }
                  $(document).on('hide.bs.modal','#modalDetail', function () {
                    var urutan = document.getElementById("urutan");
                    urutan.innerHTML = null;
                  });
                  </script>
                </tbody>
              </table>
            </div><!--table-responsive-->
          </div>

          <!-- Modal tambah stasiun-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="tambah" action="<?php echo site_url('DataRute/insertDetailRute') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Rute</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="pesan_tambah" class="alert alert-danger" style="display:none" role="alert">
                      Harap isi semua data
                    </div>
                    <div class="form-group row">
                      <label for="rute" class="col-sm-4 col-form-label">Nama Stasiun</label>
                      <div class="col-sm-8">
                        <select class="custom-select" name="stasiun">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun." (".$row->kota.")" ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="id_rute" value="<?= $id ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="tambah()" class="btn btn-primary">Tambah</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal tambah-->
          <!-- Modal Edit-->
          <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="edit" action="<?php echo site_url('DataRute/updateDetail') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Rute</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="pesan_edit" class="alert alert-danger" style="display:none" role="alert">
                      Harap isi semua data
                    </div>
                    <div class="form-group row">
                      <label for="rute" class="col-sm-4 col-form-label">Nama Stasiun</label>
                      <div class="col-sm-8">
                        <select class="custom-select" name="stasiun_edit">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun." (".$row->kota.")" ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="id_edit" value="">
                    <input type="hidden" name="id_rute" value="<?= $id ?>">
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
                <form class="" action="<?php echo site_url('DataRute/deleteDetail') ?>" method="get">
                  <input type="hidden" name="id_hapus" value="">
                  <input type="hidden" name="id_rute" value="<?= $id ?>">
                  <div class="modal-body">
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
