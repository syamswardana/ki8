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
      <div class="col-md-6 d-none d-sm-block" id="image-kereta" style="height:100%;">
      </div>
      <div class="col-md-6" style="height:100%;" id="container-login">
        <div class="col-md-8 offset-md-2 vertical-center" id="form-login">
          <h4>CV Karya Indah Delapan Ekspress</h4>
          <form action="<?php echo site_url('login/auth'); ?>" method="post">
            <?php if ($this->session->flashdata('msg')!=null) {
              echo '<div class="alert alert-danger" role="alert">';
              echo $this->session->flashdata('msg');
              echo '</div>';
            } ?>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <!-- <button type="submit" class="btn btn-warning">Submit</button> -->
            <input type="submit" class="btn btn-warning" name="" value="Submit">
          </form>
        </div>

      </div>
    </div>
  </body>
</html>
