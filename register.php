<?php
include 'admin/conf/function.php';

if (isset($_POST["submit"])) {
  if (tambahUser($_POST) > 0) {

    echo  "
          <script>
            alert('Data Berhasil Ditambahkan!');
            document.location.href = 'http://localhost/sawtopsis/'
          </script>";
  } else {
    echo 'Data gagal ditambahkan';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html">SPK SAW<b> VS </b>TOPSIS</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Silahkan Daftar </p>

        <form action="" method="post" onsubmit="return registerValid()">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nama" name="nama" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="valid-feedback" id="feedback-pass">
              Looks good!
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Konfirmasi Password" id="konfirmasi_password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="valid-feedback" id="feedback_konf">
              Looks good!
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div> -->
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-secondary btn-block" id="submit" name="submit">Sign Up</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <!-- <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p> -->
        <p class="mb-0">
          <a href="register.html" class="text-center">Daftar Disini</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    $(function registerValid() {
      // let status1 = false;
      let status2 = false;
      let status3 = false;
      $('#password').change(function() {
        console.log(document.getElementById('password'));
        let password = document.getElementById('password').value;
        if (password.length < 7) {
          $('#password').addClass('is-invalid');
          $('#password').removeClass('is-valid');
          $('#feedback-pass').removeClass('valid-feedback');
          $('#feedback-pass').addClass('invalid-feedback');
          $('#feedback-pass').html('Password minimal memiliki 8 kata');

          status2 = false;
        } else {
          $('#password').removeClass('is-invalid');
          $('#password').addClass('is-valid');
          $('#feedback-pass').removeClass('valid-feedback');
          $('#feedback-pass').addClass('invalid-feedback');
          $('#feedback-pass').html('Looks Good');

          status2 = true;
        }
      })
      $('#konfirmasi_password').change(function() {
        let password = document.getElementById('password').value;
        let konfirmasi_password = document.getElementById('konfirmasi_password').value;
        if (password === konfirmasi_password) {
          $('#konfirmasi_password').removeClass('is-invalid');
          $('#konfirmasi_password').addClass('is-valid');
          $('#feedback_konf').addClass('valid-feedback');
          $('#feedback_konf').removeClass('invalid-feedback');
          $('#feedback_konf').html('Looks Good');

          status3 = true
        } else {
          $('#konfirmasi_password').addClass('is-invalid');
          $('#konfirmasi_password').removeClass('is-valid');
          $('#feedback_konf').removeClass('valid-feedback');
          $('#feedback_konf').addClass('invalid-feedback');
          $('#feedback_konf').html('Password dan Konfirmasi Password Harus Sama !');

          status3 = false;
        }
      })
      $('#submit').click(function() {
        if (status2 == true && status3 == true) {
          console.log('true');
          return true;
        } else {
          alert('Data Tidak Valid, Lengkapi Persyaratan!!!')
          return false;
        }
      })
    })
  </script>
</body>

</html>