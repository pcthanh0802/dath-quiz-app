<?php
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
} else {
  // Page
  require_once "./database.php";
  require "../quizApp/assets/components/head.php";
  $sql = "SELECT quiz.id AS id, name, lastModified, dateCreate, username FROM quiz JOIN account ON creatorId = account.id";
  $quizArray = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

  <div id="main-content">
    <div class="page-heading">
      <div class="page-title mb-2">
        <h1 style="display:inline" class="me-4">Quiz manager</h1>
        <!-- <div class="mb-4" <?php if ($_SESSION['role'] == 1) echo "style='display:inline'" ?>>
          <a href="./index.php?page=owner_create_quiz2"><button style="display:inline" class="btn btn-primary rounded-pill mb-4" <?php if ($_SESSION['role'] != 1) echo 'hidden' ?>>
            Add quiz
          </button></a>
        </div> -->
      </div>
      <section class="section">
          <div class="card h-100 mb-4">
            <div class="card-header">
              <h3 class="card-title">Quiz list</h3>
            </div>
            <div class="card-body" style="width:100%">
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Last modified</th>
                    <th>Date create</th>
                    <th>Creator</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($quizArray as $quiz) {
                  ?>
                    <tr>
                      <td><?= $quiz['name'] ?></td>
                      <td><?= date_format(date_create($quiz['lastModified']), "d/m/Y H:i:s") ?></td>
                      <td><?= date_format(date_create($quiz['dateCreate']), "d/m/Y")?></td>
                      <td><?= $quiz['username'] ?></td>
                      <td>
                        <a href="./index.php?page=owner_view_quiz&quizID=<?=$quiz['id']?>" class="btn btn-sm rounded-pill btn-outline-success">
                          View
                        </a>
                        <a href="index.php?page=edit_quiz2&quizID=<?=$quiz['id']?>" class="btn btn-sm rounded-pill btn-outline-primary">
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