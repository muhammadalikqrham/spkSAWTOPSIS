<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php
$id = $_GET['id_kriteria'];
$bobot = query("SELECT * FROM tb_bobotkriteria WHERE id_bobot = '" . $id . "'")[0];
if (isset($_POST["simpan"])) {
  if (ubahKriteria($_POST) > 0) {
    echo "<script>alert('berhasil')
    document.location.href = 'index.php';
    </script>";
  } else {
    echo "<script>alert('gagal')</script>";
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>KRITERIA</h1>
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
        <h3 class="card-title">Tabel Data Kriteria</h3>

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
        <!-- /.card -->

        <div class="card">
          <div class="card-header" style="background-color: #afe0db;">
            <h3 class="card-title">Tabel Kriteria</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="nama_bobot">Nama Bobot</label>
                <input type="hidden" name="id" class="form-control" value="<?= $bobot['id_bobot'] ?>">
                <input type="text" name="nama_bobot" class="form-control" value="<?= $bobot['nama_bobot'] ?>">
              </div>
              <div class="form-group">
                <label for="nilai_Bobot">Nilai Bobot</label>
                <input type="text" name="nilai_bobot" class="form-control" value="<?= $bobot['nilai_bobot'] ?>">
              </div>
              <div class=" form-group">
                <button class="btn" style="background-color: #afe0db;" name="simpan">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card -->

      <?php include_once '../template/footer.php'; ?>