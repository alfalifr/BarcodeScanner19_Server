<?php
require '../db_barscan.php';
$idPeran= "PER04"; //"ID4";
$startup= false;
$sql = "SELECT id, skor FROM Peserta WHERE fk_peran = '$idPeran' ORDER BY skor DESC";
$statement = $connection->prepare($sql);
$statement->execute();
$pengunjung = $statement->fetchAll(PDO::FETCH_OBJ);
 ?>
<?php require '../header_barscan.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Score Leaderboard</h2>
      <h5>Pengunjung</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <th>Skor</th>
        </tr>
        <?php foreach($pengunjung as $perPengunjung): ?>
          <tr height="1">
            <td><?= $perPengunjung->id; ?></td>
            <td><?= $perPengunjung->skor; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require '../footer.php'; ?>
