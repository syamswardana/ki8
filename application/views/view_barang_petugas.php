<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Barang</title>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/popper.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/datatables.min.js"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/open-iconic-bootstrap.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/datatables.min.css">
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
          <a class="nav-link" href="<?php echo site_url("DataBarang") ?>">Data Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("DataStasiun") ?>">Data Stasiun</a>
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
              <a class="" href="<?php echo site_url("DataBarang") ?>"><span class="oi oi-box"></span> Data Barang</a>
            </li>
            <li class="sidebar-list">
              <a class="" href="<?php echo site_url("Visual3d") ?>"><span class="oi oi-eye"></span> Visualisasi 3D</a>
            </li>
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
            <table class="table" id="tabelBarang">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Berat (kg)</th>
                  <th scope="col">Panjang (cm)</th>
                  <th scope="col">Lebar (cm)</th>
                  <th scope="col">Tinggi (cm)</th>
                  <th scope="col">Jenis Barang</th>
                  <th scope="col">Asal</th>
                  <th scope="col">Tujuan</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($barang as $row): ?>
                  <tr>
                    <th scope="row"><?php echo $row->id ?></th>
                    <td><?php echo $row->berat ?> kg</td>
                    <td><?php echo $row->panjang; ?> cm</td>
                    <td><?php echo $row->lebar ?> cm</td>
                    <td><?php echo $row->tinggi ?> cm</td>
                    <td><?php echo $row->jenis_barang ?></td>
                    <td><?php echo $row->asal ?></td>
                    <td><?php echo $row->tujuan ?></td>
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
                $(document).ready( function () {
                    $('#tabelBarang').DataTable();
                } );
                function edit(id) {
                  $.ajax({
                    type : "GET",
                    url  : "<?php echo site_url("DataBarang/get_barang")?>",
                    dataType : "JSON",
                    data : {id:id},
                    success: function(data){
                      $.each(data,function(){
                        // $('#ModalaEdit').modal('show');
                        $('[name="id_edit"]').val(data.id);
                        $('[name="berat_edit"]').val(data.berat);
                        $('[name="panjang_edit"]').val(data.panjang);
                        $('[name="lebar_edit"]').val(data.lebar);
                        $('[name="tinggi_edit"]').val(data.tinggi);
                        $('[name="jenis_edit"]').val(data.jenis);
                        $('[name="asal_edit"]').val(data.asal);
                        $('[name="tujuan_edit"]').val(data.tujuan);
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
            </div><!--table-responsive-->
          </div>

          <!-- Modal tambah-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?php echo site_url('DataBarang/insert') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="berat" class="col-sm-2 col-form-label">Berat</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="berat" id="berat" placeholder="kg">
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
                      <label for="tinggi" class="col-sm-2 col-form-label">Tinggi</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="tinggi" id="tinggi" placeholder="cm">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="jenis" id="jenis">
                          <?php foreach ($jenis_barang as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->jenis_barang?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="asal" class="col-sm-2 col-form-label">Asal</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="asal" id="asal">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun.' ('.$row->kota.')' ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tujuan" class="col-sm-2 col-form-label">Tujuan</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="tujuan" id="tujuan">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun.' ('.$row->kota.')' ?></option>
                          <?php endforeach; ?>
                        </select>
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
          <!-- Modal edit-->
          <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?php echo site_url('DataBarang/update') ?>" method="post">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                      <label for="id" class="col-sm-2 col-form-label">ID</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="id_edit" id="id" placeholder="id" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="berat" class="col-sm-2 col-form-label">Berat</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="berat_edit" id="berat" placeholder="kg">
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
                      <label for="tinggi" class="col-sm-2 col-form-label">Tinggi</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="tinggi_edit" id="tinggi" placeholder="tinggi">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="jenis_edit" id="jenis">
                          <?php foreach ($jenis_barang as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->jenis_barang?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="asal" class="col-sm-2 col-form-label">Asal</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="asal_edit" id="asal">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun.' ('.$row->kota.')' ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="tujuan" class="col-sm-2 col-form-label">Tujuan</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="tujuan_edit" id="tujuan">
                          <?php foreach ($stasiun as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->nama_stasiun.' ('.$row->kota.')' ?></option>
                          <?php endforeach; ?>
                        </select>
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
          </div> <!--modal edit-->
          <!-- Modal Hapus-->
          <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" action="<?php echo site_url('DataBarang/delete') ?>" method="get">
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
