<?php include_once '../conf/function.php' ?>
<?php include_once '../template/header.php'; ?>
<?php

$bobot = query("SELECT * FROM tb_alternatif");

?>
<div class="content-wrapper" style="background-image: url(../../dist/img/gambarr.jpg);background-size: cover;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 style="font-size: 48  px; color:gainsboro;">Alternatif</h1>
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
    <!-- Default box
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel Data Alternatif</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div> -->
    <!-- <div class="card-body"> -->
    <!-- /.card -->
    <a href="http://localhost/sawtopsis/admin/alternatif/add_alternatif.php" class="btn mb-3" style="background-color: #abd4a9;"><i class="fas fa-plus mr-3"></i>Tambah Alternatif</a>
    <!-- <div class="card mt-3">
          <div class="card-header">
            <h3 class="card-title">Data Alternatif</h3>
          </div> -->
    <!-- /.card-header -->
    <!-- <div class="card-body"> -->
    <table id="example1" class="table table-borderless">
      <thead align="center" style="color: white; font-size: 18px; background-color: #5F9EA0;">
        <tr>
          <th style=" border:3px solid gray;">No.</th>
          <th style=" border:3px solid gray;">Nama Alternatif</th>
          <th style=" border:3px solid gray;">Ph Tanah</th>
          <th style=" border:3px solid gray;">Jenis Pupuk</th>
          <th style=" border:3px solid gray;">Tekstur Tanah</th>
          <th style=" border:3px solid gray;">Usia</th>
          <th style=" border:3px solid gray;">Ketinggian Tempat</th>
          <th style=" border:3px solid gray;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        foreach ($bobot as $row) :
        ?>
          <tr>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= ++$no ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['nama_alternatif'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ph_tanah'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['jenis_pupuk'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['tekstur_tanah'] ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['usia'], ' Bulan' ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;"><?= $row['ketinggian_tempat'] . ' Meter' ?></td>
            <td align="center" style="color:white; font-size:20px; border:2px solid gray;">
              <a href="edit_alternatif.php?id=<?= $row['id_alternatif'] ?>" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i></a>
              <a href="hapus.php?id=<?= $row['id_alternatif'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini ?')"> <i class="fas fa-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- </div> -->
    <!-- /.card-body -->
    <!-- </div> -->
    <!-- /.card -->
    <!-- </div> -->
    <!-- /.card -->
    <?php include_once '../template/footer.php' ?>