<?php
include_once '../conf/function.php';

if (hapusAlternatif($_GET['id']) > 0) {

  echo  "
          <script>
            alert('Data Berhasil Dihapus!');
            document.location.href = 'http://localhost/sawtopsis/admin/alternatif'
          </script>";
} else {
  echo 'Data gagal Dihapus';
}
