<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Barang</title>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/popper.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/three.js"></script>
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
      <div class="row" style="height:100%;margin:0;margin-top:-58px;padding-top:58px;">

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
      <div class="col-md-10" style="padding:0;" id="screen">
      	  <a href="<?php echo site_url("Visual3d") ?>" style="z-index:10; position:absolute;" class="btn btn-success">Kembali</a>
          <iframe src="<?php echo site_url('Visual3d/canvas') ?>" width="100%" height="100%"></iframe>
        </div>
      </div> <!-- col-md-10-->
    </div> <!-- row -->
  </body>
  </html>
