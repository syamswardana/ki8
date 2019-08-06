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
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/open-iconic-bootstarp.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
  </head>
  <body>
    <div class="row" style="margin:0;height:100%;">
      <h1>Sukses Petugas</h1>
      <button type="button" name="button" onclick="window.location.href='<?php site_url('login/logout') ?>'">Logout</button>
    </div>
  </body>
</html>
