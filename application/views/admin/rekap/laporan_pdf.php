<!DOCTYPE html>
<html lang="en"><head>
<style>
     table, th, td {
      border: 0.5px solid black;
      text-align:center;
      padding: 0px;
      border-spacing: 0px;
      font-family: Arial, Helvetica, sans-serif;
      width : 100%;
        }
</style>
</head><body>
  <table >
      <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Kegiatan</th>
        <th>Transaksi</th>
        <th>Tidak Terealisasi</th>
      </tr>
      <?php $no = 1; ?>
      <?php foreach ($hasil as $item) : ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $item->kegiatan ?></td>
          <td><?= $item->anggaran ?></td>
          <td><?= $item->pengeluaran ?></td>
          <td><?= $item->sisa ?></td>
      </tr>
      <?php endforeach;?>
  </table>
</body></html>