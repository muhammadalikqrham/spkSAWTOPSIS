<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php

$id = $_GET['id'];

$data = query('SELECT * FROM tb_alternatif WHERE id_alternatif = ' . $id);


if (isset($_POST['submit'])) {

  if (ubahAlternatif($_POST) > 0) {

    echo  "
          <script>
            alert('Data Berhasil Diubah!');
            document.location.href = 'http://localhost/sawtopsis/admin/alternatif'
          </script>";
  } else {
    echo 'Data gagal diubah';
  }
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Alternatif</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Title</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="card card-secondary">
          <div class="card-header" style="background-color: #abd4a9;">
            <h3 class="card-title">Input Alternatif</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="" method="post">
            <div class="card-body">
              <div class="form-group">
                <label for="bibit">Bibit</label>
                <input type="text" class="form-control" id="bibit" autocomplete="off" name="nama_bibit" value="<?= $data[0]['nama_alternatif'] ?>">
                <input type="hidden" class="form-control" id="bibit" autocomplete="off" name="id" value="<?= $data[0]['id_alternatif'] ?>">
              </div>
              <div class="form-group">
                <label for="ph_tanah">Ph Tanah</label>
                <input type="text" name="ph_tanah" class="form-control" id="ph_tanah" value="<?= $data[0]['ph_tanah'] ?>">
                <span class="text-monospace text-danger"> Input Ph Tanah hanya bisa dari 5.00 sampai 7.00 </span>
              </div>
              <div class="form-group">
                <label for="jenis_pupuk">Jenis Pupuk</label>
                <select name="jenis_pupuk" id="jenis_pupuk" class="form-control">
                  <option value="kompos" <?= $data[0]['jenis_pupuk'] == 'kompos' ? 'selected' : ''; ?>>Kompos</option>
                  <option value="hayati" <?= $data[0]['jenis_pupuk'] == 'hayati' ? 'selected' : ''; ?>>Hayati</option>
                  <option value="perangsang bunga" <?= $data[0]['jenis_pupuk'] == 'perangsang bunga' ? 'selected' : ''; ?>>Perangsang Bunga</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tekstur_tanah">Tekstur Tanah</label>
                <select name="tekstur_tanah" id="cabang" class="form-control">
                  <option value="gembur" <?= $data[0]['tekstur_tanah'] == 'gembur' ? 'selected' : ''; ?>>Gembur</option>
                  <option value="lempung" <?= $data[0]['tekstur_tanah'] == 'lempung' ? 'selected' : ''; ?>>Lempung Sekam</option>
                  <option value="lainnya" <?= $data[0]['tekstur_tanah'] == 'lainnya' ? 'selected' : ''; ?>>lainnya</option>
                </select>
              </div>
              <div class="form-group">
                <label for="usia">Usia (Bulan)</label>
                <input type="text" name="usia" class="form-control" id="usia" value="<?= $data[0]['usia'] ?>">
                <span class="text-monospace text-danger"> jika bilangan decimal gunakan titik (.) </span>
              </div>
              <div class="form-group">
                <label for="ketinggian_tempat">Ketinggian Tempat</label>
                <input type="text" name="ketinggian_tempat" class="form-control" id="ketinggian_tempat" value="<?= $data[0]['ketinggian_tempat'] ?>">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn" name="submit" style="background-color: #abd4a9;">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card-body -->
      <!-- <div class="card-footer">
    Footer
  </div> -->
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
    <script>
      function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
          textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
              this.value = "";
            }
          });
        });
      }

      setInputFilter(document.getElementById("ph_tanah"), function(value) {
        return /^-?\d*[.,]?\d*$/.test(value) && (value === "" || parseFloat(value) <= 7.80) && (value === "" || parseFloat(value) >= 5);
      });
      setInputFilter(document.getElementById("ketinggian_tempat"), function(value) {
        return /^-?\d*[.,]?\d*$/.test(value) && (value === "" || parseFloat(value) <= 1250);
      });
      setInputFilter(document.getElementById("usia"), function(value) {
        return /^-?\d*[.,]?\d*$/.test(value);
      });
      $('#usia').change(function() {
        if (document.getElementById('usia').value < 4) {
          console.log('oke');
          document.getElementById('usia').value = "";
        }

      })
      $('#ketinggian_tempat').change(function() {
        if (document.getElementById('ketinggian_tempat').value < 400) {
          console.log('oke');
          document.getElementById('ketinggian_tempat').value = "";
        }

      })
    </script>
    <?php include_once '../template/footer.php' ?>