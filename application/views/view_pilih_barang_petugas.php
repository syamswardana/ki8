<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Pilih Barang</title>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/popper.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/datatables.min.js"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/open-iconic-bootstrap.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/datatables.min.css">
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
          <a class="nav-link" href="<?php echo site_url("DataBarang") ?>">Data Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url("Visual3d") ?>">Visualisasi 3D</a>
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
              <a class="" href="<?php echo site_url("DataBarang") ?>"><span class="oi oi-box"></span> Data Barang</a>
            </li>
            <li class="sidebar-list active">
              <a class="" href="<?php echo site_url("Visual3d") ?>"><span class="oi oi-eye"></span> Visualisasi 3D</a>
            </li>
          </li>
        </ul>
      </div>
      <div class="col-md-10">
        <!-- Button trigger modal -->
        <form class="" id="parameter" action="<?php echo site_url("Visual3d/visual"); ?>" method="post">
          <div class="container" id="main">
          <div class="row">
            <div class="col">
              <h4>Masukan ukuran kontainer dan pilih barang yang akan dimasukan</h4>
            </div>
          </div>
          <br>
          <div id="pesan" class="alert alert-danger" style="display:none" role="alert">
            Harap isi semua data
          </div>
          <div id="ukuran" class="alert alert-warning" role="alert">
            Ukuran maksimal Panjang : 20; Lebar : 2.5; Tinggi : 2.5
          </div>
          <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-6">
              <span style="font-size:larger">Ukuran Kontainer</span>
            </div>
            <div class="col-lg-10 col-md-9">
              <div class="row">
                <!-- panjang -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="input-group">
                    <input type="number" class="form-control" name="panjang" placeholder="Panjang">
                    <div class="input-group-append">
                      <span class="input-group-text">M</span>
                    </div>
                  </div>
                </div>
                <!-- lebar -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="input-group">
                    <input type="number" class="form-control" name="lebar" placeholder="Lebar">
                    <div class="input-group-append">
                      <span class="input-group-text">M</span>
                    </div>
                  </div>
                </div>
                <!-- tinggi -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="input-group">
                    <input type="number" class="form-control" name="tinggi" placeholder="tinggi">
                    <div class="input-group-append">
                      <span class="input-group-text">M</span>
                    </div>
                  </div>
                </div>
                <!-- berat -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="input-group">
                    <input type="number" class="form-control" name="berat" placeholder="Berat maks">
                    <div class="input-group-append">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <br>
          <!-- table -->
          <div class="table-responsive">
            <table class="table" id="tableBarang">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" name="" id="checkboxall" onclick="checkall()" value="">
                  </th>
                  <th scope="col">ID</th>
                  <th scope="col">Berat (kg)</th>
                  <th scope="col">Panjang (cm)</th>
                  <th scope="col">Lebar (cm)</th>
                  <th scope="col">Tinggi (cm)</th>
                  <th scope="col">Jenis Barang</th>
                  <th scope="col">Asal</th>
                  <th scope="col">Tujuan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($barang as $row): ?>
                  <tr>
                    <td>
                        <input type="checkbox" name="barang[]" id = "barang[]" value="<?php echo $row->id ?>">
                    </td>
                    <th scope="row"><?php echo $row->id ?></th>
                    <td><?php echo $row->berat ?> kg</td>
                    <td><?php echo $row->panjang; ?> cm</td>
                    <td><?php echo $row->lebar ?> cm</td>
                    <td><?php echo $row->tinggi ?> cm</td>
                    <td><?php echo $row->jenis_barang ?></td>
                    <td><?php echo $row->asal ?></td>
                    <td><?php echo $row->tujuan ?></td>
                  </tr>
                <?php endforeach; ?>

                <script type="text/javascript">
                //inisiasi lib datatables
                $(document).ready( function () {
                    var table = $('#tableBarang').DataTable({
                      "order": [],
                      "paging": false,
                      "scrollY": 300,
                      "columnDefs": [
                        { "orderable": false, "targets": 0 }
                      ]
                    });
                } );
                function checkall() {
                  var barang = document.getElementsByName("barang[]");
                  if ($('#checkboxall').is(":checked")) {
                    console.log("check");
                    for (var i = 0; i < barang.length; i++) {
                      barang[i].checked = true;
                    }
                  } else {
                    console.log("uncheck");
                    for (var i = 0; i < barang.length; i++) {
                      barang[i].checked = false;
                    }
                  }
                }
                function next() {
                  var panjang =  $("input[name=panjang]").val();
                  var lebar = $("input[name=lebar]").val();
                  var tinggi = $("input[name=tinggi]").val();
                  var berat = $("input[name=berat]").val();
                  var barang = document.getElementsByName("barang[]");
                  var checked = 0;

                  for (var i = 0; i < barang.length; i++) {
                    if (barang[i].checked) {
                      checked++;
                    }
                  }
                  console.log(checked);

                  if (panjang===""||lebar===""||tinggi===""||berat===""||checked == 0) {
                    element = document.getElementById('pesan');
                    element.removeAttribute("style");
                  } else if (parseInt(panjang) > 20 || parseInt(lebar) > 2.5 || parseInt(tinggi) > 2.5) {
                    element = document.getElementById('ukuran');
                    element.removeAttribute("style");
                    console.log(panjang);
                    console.log(lebar);
                    console.log(tinggi);
                  } else {
                    document.forms["parameter"].submit();
                  }
                }
                </script>
                </tbody>
              </table>
            </div><!--table-responsive-->
            <div class="row">
              <div class="col-md-2 offset-md-10">
                <button type="button" class="btn btn-success" onclick="next()" style="float:right">Next</button>
              </div>
            </div>
          </div>
        </div> <!-- col-md-10-->
        </form>
      </div> <!-- row -->
    </body>
    </html>
