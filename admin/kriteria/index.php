<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php
$bobot = query("SELECT * FROM tb_bobotkriteria");

?>
<div class="content-wrapper" style="background-image: url(../../dist/img/gambarr.jpg);background-size: cover;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 64px; color:gainsboro;">KRITERIA</h1>
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
    <!-- <div class="card">
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
      <div class="card-body"> -->
    <!-- /.card -->

    <!-- <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tabel Kriteria</h3>
          </div> -->
    <!-- /.card-header -->
    <!-- <div class="card-body"> -->
    <table id="example1" class="table table-borderless" width="100%">
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr>
          <th style=" border:3px solid gray;">No.</th>
          <th style=" border:3px solid gray;">Nama Kriteria</th>
          <th style=" border:3px solid gray;">Bobot</th>
          <th style=" border:3px solid gray;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>

          <tr>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= ++$no ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_bobot'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nilai_bobot'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><a href="edit.php?id_kriteria=<?= $row['id_bobot'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <!-- <tfoot>
            <tr>
              <th>No.</th>
              <th>Nama Kriteria</th>
              <th>Bobot</th>
            </tr>
          </tfoot> -->
    </table>
    <!-- </div> -->
    <!-- /.card-body -->
    <!-- </div> -->
    <!-- /.card -->
    <!-- </div> -->
    <!-- /.card -->

    <?php include_once '../template/footer.php'; ?>