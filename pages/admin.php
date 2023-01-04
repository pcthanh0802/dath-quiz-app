<?php
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
} else {
  // Page
  require_once "./database.php";
  require "../quizApp/assets/components/head.php";
  $sql = "SELECT player.id, email, gender, dob, nationality, username, password, role 
          FROM player JOIN account ON player.id = account.id";
  $playerArray = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>

  <div id="main-content">
    <div class="page-heading">
      <div class="page-title mb-2">
        <h1 style="display:inline" class="me-4">Player manager</h1>
        <div class="mb-4" <?php if ($_SESSION['role'] == 1) echo "style='display:inline'" ?>>
          <button style="display:inline" data-bs-toggle="modal" data-bs-target="#insertEmployee" class="btn btn-primary rounded-pill mb-4" <?php if ($_SESSION['role'] != 1) echo 'hidden' ?>>
            Add player
          </button>
        </div>
      </div>
      <section class="section">
          <div class="card h-100 mb-4">
            <div class="card-header">
              <h3 class="card-title">Player list</h3>
            </div>
            <div class="card-body" style="width:100%">
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email address</th>
                    <th>Date of birth</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($playerArray as $player) {
                  ?>
                    <tr>
                      <td><?= $player['id'] ?></td>
                      <td><?= $player['username'] ?></td>
                      <td><?= $player['password'] ?></td>
                      <td><?= $player['email'] ?></td>
                      <td><?= date_format(date_create($player['dob']), "d/m/Y")?></td>
                      <td>
                        <a href="./index.php?page=profile&id=<?= $player['id'] ?>" class="btn btn-sm rounded-pill btn-outline-success">
                          View
                        </a>
                        <a href="./index.php?page=player-delete-processing&id=<?= $player['id'] ?>" class="btn btn-sm rounded-pill btn-outline-danger">
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

  <div class="modal fade" id="insertEmployee" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">Add new player</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./index.php?page=player-insert-processing" method="POST" class="form form-horizontal">
          <div class="modal-body">
            <div class="row">

              <div class="col-md-4">
                <label>Username</label><span class="text-danger">*</span>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <input type="text" name="username" class="form-control" placeholder="Username..." id="first-name-icon" required autocomplete="off" />
                    <div class="form-control-icon">
                      <i class="bi bi-person-vcard"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Password</label><span class="text-danger">*</span>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <input type="text" name="password" class="form-control" placeholder="Password..." id="first-name-icon" required autocomplete="off" />
                    <div class="form-control-icon">
                      <i class="bi bi-shield-lock"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Date of birth</label>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <input type="date" name="dob" class="form-control" placeholder="Date of birth..." id="first-name-icon" required autocomplete="off" />
                    <div class="form-control-icon">
                      <i class="bi bi-calendar"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Email address</label>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <input type="email" name="email" class="form-control" placeholder="Email address..." id="first-name-icon" required autocomplete="off" />
                    <div class="form-control-icon">
                      <i class="bi bi-envelope"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Nationality</label>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <input type="text" name="nationality" class="form-control" placeholder="Nationality..." id="first-name-icon" required autocomplete="off" />
                    <div class="form-control-icon">
                      <i class="bi bi-globe"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Role</label><span class="text-danger">*</span>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <select name="role" id="role" required style="width:100%">
                      <option selected hidden>Please choose a role...</option>
                      <option value="1">Admin</option>
                      <option value="0">Player</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <label>Gender</label><span class="text-danger">*</span>
              </div>
              <div class="col-md-8">
                <div class="form-group has-icon-left">
                  <div class="position-relative">
                    <select name="gender" id="gender" required style="width:100%">
                      <option selected hidden>Please choose employee's gender...</option>
                      <option value="0">Male</option>
                      <option value="1">Female</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Insert</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
  require "../quizApp/assets/components/foot.php";
}
?>