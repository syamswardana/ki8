<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Rute</title>
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
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
              Tambah Rute
            </button>
            <br><br>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID Rute</th>
                    <th scope="col">Nama Rute</th>
                    <th scope="col">Detail Rute</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rute as $row): ?>
                    <tr>
                      <th scope="row"><?= $row->id ?></th>
                      <td>Rute <?= $row->nama_rute ?></td>
                      <td> <button type="button" name="button" class="btn btn-info"  data-toggle="modal" onclick="detail(<?= $row->id ?>)" data-target="#modalDetail">Detail Rute</button> </td>
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
                      url  : "<?php echo site_url("DataRute/get_rute")?>",
                      dataType : "JSON",
                      data : {id:id},
                      success: function(data){
                        $.each(data,function(){
                          // $('#ModalaEdit').modal('show');
                          console.log(data);
                          $('[name="id_edit"]').val(data.id);
                          $('[name="rute_edit"]').val(data.rute);
                        });
                      }
                    });
                  }
                  function hapus(id) {
                    $('[name="id_hapus"]').val(id);
                  }
                  function tambah() {
                    let rute =  $("input[name=rute]").val();
                    if (rute==="") {
                      element = document.getElementById('pesan_tambah');
                      element.removeAttribute("style");
                    } else {
                      document.forms["tambah"].submit();
                    }
                  }
                  function update() {
                    let rute =  $("input[name=rute_edit]").val();
                    if (rute==="") {
                      element = document.getElementById('pesan_edit');
                      element.removeAttribute("style");
                    } else {
                      document.forms["edit"].submit();
                    }
                  }
                  function detail(id) {
                    $.ajax({
                      type : "GET",
                      url : "<?php echo site_url("DataRute/get_detail_rute")?>",
                      dataType : "JSON",
                      data : {id:id},
                      success: function(data){
                        var i = 0;
                        $.each(data,function(){
                          var urutan = document.getElementById("urutan");
                          var element = '<div class=\"form-group row\">'+
                          '<label for=\"stasiun\" class=\"col-sm-4 col-form-label\">Urutan '+(i+1)+'</label>'+
                          '<div class=\"col-sm-6\">'+
                          '<select class=\"form-control\" id=\"'+data[i].id+'\" name=\"stasiun\" id=\"rute\">'+
                          <?php foreach ($stasiun as $row ): ?>
                          <?php echo '\'<option value="'.$row->id.'">'.$row->nama_stasiun.' ('.$row->kota. ')</option>\'+' ?>
                          <?php endforeach; ?>
                          '</select>'+
                          '</div>'+
                          '<div class=\"col-sm-2\">'+
                          '<button type=\"button\" name=\"button\" class=\"btn btn-danger rounded-circle\">X</button>'+
                          '</div>'+
                          '</div>';
                          urutan.innerHTML += element;
                          console.log(data[i].id);
                          $("#"+data[i].id).val("6");
                          i++;
                        });
                      },

                    });
                    $.ajax({
                      type: ""
                    });
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

          <!-- Modal detail-->
          <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="detail" action="<?php echo site_url('DataStasiun/insert') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List stasiun dalam rute</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="pesan_tambah" class="alert alert-danger" style="display:none" role="alert">
                      Harap isi semua data
                    </div>
                    <button type="button" class="btn btn-primary" name="button">Tambah Kolom</button>
                    <hr>
                    <div id="urutan">
                      <!-- <div class="form-group row">
                        <label for="stasiun" class="col-sm-4 col-form-label">Urutan 1</label>
                        <div class="col-sm-6">
                          <select class="form-control" name="stasiun" id="rute">
                            <?php foreach ($stasiun as $row ): ?>
                              <option value="<?= $row->id; ?>"><?= $row->nama_stasiun ?> (<?= $row->kota ?>)</option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-sm-2">
                          <button type="button" name="button" class="btn btn-danger rounded-circle">X</button>
                        </div>
                      </div> -->
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="tambah()" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!--modal detail-->
          <!-- Modal tambah rute-->
          <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form class="" id="tambah" action="<?php echo site_url('DataRute/insert') ?>" method="post">
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
                      <label for="rute" class="col-sm-4 col-form-label">Nama Rute</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="rute" id="rute" placeholder="Masukan nama rute">
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
                <form class="" id="edit" action="<?php echo site_url('DataRute/update') ?>" method="post">
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
                      <label for="id_stasiun" class="col-sm-4 col-form-label">ID </label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="id_edit" id="id_edit" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="rute_edit" class="col-sm-4 col-form-label">Nama Rute</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="rute_edit" id="rute" placeholder="Masukan Rute">
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
                <form class="" action="<?php echo site_url('DataRute/delete') ?>" method="get">
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
