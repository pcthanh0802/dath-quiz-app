<?php
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
} else {
  // Page
  require_once "./database.php";
  require "../quizApp/assets/components/head.php";
  $id = $_SESSION['userID'];
  $sql = "SELECT DISTINCT category FROM quiz_category";
  $categoryArray = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
  $sql = "SELECT quiz.id, name, lastModified, dateCreate, creatorId, username, COUNT(play_attempt.id) AS play_attempt, AVG(score) AS avg_score  
          FROM quiz LEFT JOIN play_attempt ON quizId = quiz.id JOIN account ON account.id = quiz.creatorId 
          GROUP BY quiz.id ORDER BY play_attempt,score DESC LIMIT 10";
  $quizTrend = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

  <div id="main-content">
    <div class="page-heading">
      <div class="page-title mb-2">
        <h1 style="display:inline" class="me-4">Quiz</h1>
      </div>
      <section class="section">
          <div class="card h-100 mb-4">
            <div class="card-header">
              <h3 class="card-title">Trending</h3>
            </div>
            <div class="card-body" style="width:100%">
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Number of plays</th>
                    <th>Average score</th>
                    <th>Your attempts</th>
                    <th>Your best score</th>
                    <th>Your average score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($quizTrend as $quiz) {
                    $sql = "SELECT MAX(score) AS max_score, COUNT(playDateTime) AS play_attempt, AVG(score) AS avg_score
                            FROM quiz LEFT JOIN play_attempt ON play_attempt.quizId = quiz.id LEFT JOIN account ON play_attempt.playerId = account.id 
                            WHERE account.id = \"$id\" AND quiz.id =\"".$quiz['id']."\"
                            GROUP BY play_attempt.quizId";
                    $personalAchievement = $conn->query($sql);
                    $exists = 0;
                    if(mysqli_num_rows($personalAchievement)){
                      $exists = 1;
                      $pA = $personalAchievement->fetch_all(MYSQLI_ASSOC)[0];
                    }
                  ?>
                    <tr>
                      <td><?= $quiz['name'] ?></td>
                      <td><?= ($quiz['play_attempt'])?$quiz['play_attempt']:0?></td>
                      <td><?= ($quiz['play_attempt'])?number_format($quiz['avg_score'],2):0?></td>
                      <td><?= ($exists)?$pA['play_attempt']:0?></td>
                      <td><?= ($exists)?$pA['max_score']:0?></td>
                      <td><?= ($exists)?number_format($pA['avg_score'],2):0?></td>
                      <td>
                        <a href="./index.php?page=player_view_quiz&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-success">
                          View
                        </a>
                        <a href="./index.php?page=play-init-processing&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-primary">
                          Play
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
      </section>

      <section class="section">
        <?php
        foreach ($categoryArray as $category) {
          $type = $category['category'];
          $sql = "SELECT quiz.id, name, lastModified, dateCreate, AVG(score) AS avg_score, COUNT(playdateTime) AS play_attempt 
                  FROM quiz JOIN quiz_category ON quizId = quiz.id LEFT JOIN play_attempt ON play_attempt.quizId = quiz.id
                  WHERE quiz_category.category = \"$type\"
                  GROUP BY play_attempt.quizId";
          $quizArray = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        ?>
          <div class="card h-100 mb-4">
            <div class="card-header">
              <h3 class="card-title">
                Category: <?= $category['category'] ?> 
              </h3>
            </div>
            <div class="card-body" style="width:100%">
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Number of plays</th>
                    <th>Average score</th>
                    <th>Your attempts</th>
                    <th>Your best score</th>
                    <th>Your average score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($quizArray as $quiz) {
                    $sql = "SELECT MAX(score) AS max_score, COUNT(playDateTime) AS play_attempt, AVG(score) AS avg_score
                            FROM quiz JOIN quiz_category ON quizId = quiz.id LEFT JOIN play_attempt ON play_attempt.quizId = quiz.id LEFT JOIN account ON play_attempt.playerId = account.id 
                            WHERE quiz_category.category = \"$type\" AND quiz.id = \"".$quiz['id']."\" AND account.id = $id 
                            GROUP BY play_attempt.quizId";
                    $personalAchievement = $conn->query($sql);
                    $exists = 0;
                    if(mysqli_num_rows($personalAchievement)){
                      $exists = 1;
                      $pA = $personalAchievement->fetch_all(MYSQLI_ASSOC)[0];
                    } 
                  ?>
                    <tr>
                      <td><?= $quiz['name'] ?></td>
                      <td><?= ($quiz['play_attempt'])?$quiz['play_attempt']:0?> </td>
                      <td><?= ($quiz['play_attempt'])?number_format($quiz['avg_score'],2):0?></td>
                      <td><?= ($exists)?$pA['play_attempt']:0?></td>
                      <td><?= ($exists)?$pA['max_score']:0?></td>
                      <td><?= ($exists)?number_format($pA['avg_score'],2):0?></td>
                      <td>
                        <a href="./index.php?page=player_view_quiz&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-success">
                          View
                        </a>
                        <a href="./index.php?page=play-init-processing&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-primary">
                          Play
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>
      </section>
    </div>
  </div>

<?php
  require "../quizApp/assets/components/foot.php";
}
?>