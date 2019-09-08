<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Kontainer</title>
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
      <img src="<?= base_url() ?>assets/images/logo.png" width="30" height="30" alt="">
      Karya Indah Delapan
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto " id="menu">
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('DataPetugas') ?>"><span class="oi oi-person"></span> Data Petugas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url("DataStasiun") ?>">Data Stasiun</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?= site_url("DataKontainer") ?>">Data Kontainer</a>
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
                    <th scope="col">ID Kontainer</th>
                    <th scope="col">Rute</th>
                    <th scope="col">Panjang (cm)</th>
                    <th scope="col">Lebar (cm)</th>
                    <th scope="col">Tinggi (cm)</th>
                    <th scope="col">Berat Max (kg)</th>
                    <th scope="col">Tgl digunakan</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($kontainer as $row): ?>
                    <tr>
                      <th scope="row"><?php echo $row->id ?></th>
                      <td>rute <?php echo $row->rute ?></td>
                      <td><?php echo $row->panjang ?> cm</td>
                      <td><?php echo $row->lebar ?> cm</td>
                      <td><?php echo $row->tinggi ?> cm</td>
                      <td><?php echo $row->berat_maksimal ?> kg</td>
                      <td><?php echo $row->tanggal_digunakan ?></td>
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
                      url  : "<?php echo site_url("DataKontainer/get_kontainer")?>",
                      dataType : "JSON",
                      data : {id:id},
                      success: function(data){
                        $.each(data,function(){
                          // $('#ModalaEdit').modal('show');
                          $('[name="id_edit"]').val(data.id);
                          $('[name="rute_edit"]').val(data.rute_id);
                          $('[name="panjang_edit"]').val(data.panjang);
                          $('[name="lebar_edit"]').val(data.lebar);
                          $('[name="tinggi_edit"]').val(data.tinggi);
                          $('[name="berat_edit"]').val(data.berat_maksimal);
                          $('[name="tanggal_edit"]').val(data.tanggal_digunakan);
                        });
                      }
                    });
                  }
                  function hapus(id) {
                    $('[name="id_hapus"]').val(id);
                  }
                  </script>
                </tbody>
              </table>

            </div>
          </div>

          <!-- Modal tambah-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?php echo site_url('DataKontainer/insert') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kontainer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="rute" class="col-sm-2 col-form-label">Rute</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="rute" id="rute">
                          <?php foreach ($rutes as $row ): ?>
                            <option value="<?= $row->id; ?>">rute <?= $row->nama_rute ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="panjang" class="col-sm-2 col-form-label">Panjang</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="panjang" id="panjang" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lebar" class="col-sm-2 col-form-label">Lebar</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="lebar" id="lebar" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Tinggi" class="col-sm-2 col-form-label">Tinggi</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control"name="tinggi" id="tinggi" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="berat" class="col-sm-2 col-form-label">Berat max</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="berat" id="berat" placeholder="kg">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Digunakan</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal tambah-->
          <!-- Modal Edit-->
          <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?= site_url('DataKontainer/update') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Kontainer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="id" class="col-sm-2 col-form-label">ID Kontainer</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="id" name="id_edit" value="1" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="rute" class="col-sm-2 col-form-label">Rute</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="rute_edit" id="rute">
                          <?php foreach ($rutes as $row ): ?>
                            <option value="<?= $row->id; ?>">rute <?= $row->nama_rute ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="panjang" class="col-sm-2 col-form-label">Panjang</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="panjang_edit" id="panjang" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="lebar" class="col-sm-2 col-form-label">Lebar</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="lebar_edit" id="lebar" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Tinggi" class="col-sm-2 col-form-label">Tinggi</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="tinggi_edit" id="tinggi" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="berat" class="col-sm-2 col-form-label">Berat max</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="berat_edit" id="berat" placeholder="kg">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Digunakan</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" name="tanggal_edit" id="tanggal" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal Edit-->
          <!-- Modal Hapus-->
          <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?= site_url('DataKontainer/delete') ?>" method="get">
                  <input type="hidden" name="id_hapus" value="">
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
