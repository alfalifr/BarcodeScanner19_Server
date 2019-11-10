<?php
require '../db_barscan.php';
$idPeran= "PER02"; //"ID2";
$startup= true;
$sql = "SELECT uname, skor FROM Peserta WHERE fk_peran = '$idPeran' ORDER BY skor DESC";
$statement = $connection->prepare($sql);
$statement->execute();
$startup = $statement->fetchAll(PDO::FETCH_OBJ);
 ?>
<?php require '../header_barscan.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Score Leaderboard</h2>
      <h5>Startup</h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>User Name</th>
          <th>Skor</th>
        </tr>
        <?php foreach($startup as $perStartup): ?>
          <tr height="1">
            <td><?= $perStartup->uname; ?></td>
            <td><?= $perStartup->skor; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require '../footer.php'; ?>
