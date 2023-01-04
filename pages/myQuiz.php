<?php
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
} else {
  // Page
  require_once "./database.php";
  require "../quizApp/assets/components/head.php";
  $id = $_SESSION['userID'];
  $sql = "SELECT MAX(score) AS max_score, AVG(score) AS avg_score, COUNT(playDateTime) AS play_attempt, name, lastModified, dateCreate, quiz.id, score
          FROM quiz JOIN account ON creatorId = account.id LEFT JOIN play_attempt ON quiz.id = play_attempt.quizId
          WHERE quiz.creatorId = \"$id\"
          GROUP BY quiz.id";
  $quizArray = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

  <div id="main-content">
    <div class="page-heading">
      <div class="page-title mb-2">
        <h1 style="display:inline" class="me-4">My quizzes</h1>
        <div class="mb-4" <?php if ($_SESSION['role'] == 0) echo "style='display:inline'" ?>>
          <a href="./index.php?page=owner_create_quiz"><button style="display:inline" class="btn btn-primary rounded-pill mb-4">
            Add quiz
          </button></a>
        </div>
      </div>
      <section class="section">
          <div class="card h-100 mb-4">
            <div class="card-header">
              <h3 class="card-title">My quizzes</h3>
            </div>
            <div class="card-body" style="width:100%">
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Last modified</th>
                    <th>Num of questions</th>
                    <th>Num of attempts</th>
                    <th>Average score</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($quizArray as $quiz) {
                    $sql = "SELECT MAX(score) AS max_score, COUNT(question.id) AS question_num
                            FROM quiz JOIN account ON creatorId = account.id 
                            LEFT JOIN play_attempt ON play_attempt.quizId = quiz.id AND play_attempt.playerId = account.id 
                            JOIN question ON question.quizId = quiz.id
                            WHERE quiz.id = \"".$quiz['id']."\" AND quiz.creatorId = $id 
                            GROUP BY play_attempt.quizId";
                    $personalAchievement = $conn->query($sql);
                    $exist = 0;
                    if(mysqli_num_rows($personalAchievement)){
                      $exist = 1;
                      $pA = $personalAchievement->fetch_all(MYSQLI_ASSOC)[0];
                    }
                    $sql = "SELECT COUNT(question.id) AS question_num FROM quiz JOIN question ON quiz.id = question.quizId WHERE quiz.id=\"".$quiz['id']."\"";
                    $question_num = $conn->query($sql)->fetch_assoc();
                  ?>
                    <tr>
                      <td><?= $quiz['name'] ?></td>
                      <td><?= date_format(date_create($quiz['lastModified']), "d/m/Y H:i:s") ?></td>
                      <td><?= $question_num['question_num'] ?></td>
                      <td><?= ($quiz['play_attempt'])?$quiz['play_attempt']:0 ?></td>
                      <td><?= ($quiz['play_attempt'])?number_format($quiz['avg_score'],2):0 ?></td>
                      <td>
                        <a href="./index.php?page=owner_view_quiz&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-success">
                          View
                        </a>
                        <a href="index.php?page=edit_quiz&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-primary">
                          Edit
                        </a>
                        <a href="./index.php?page=quiz-delete-processing&quizID=<?= $quiz['id'] ?>" class="btn btn-sm rounded-pill btn-outline-danger">
                          Delete
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
      </section>
    </div>
  </div>
<?php
  require "../quizApp/assets/components/foot.php";
}
?>