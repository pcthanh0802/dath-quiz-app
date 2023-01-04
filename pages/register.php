<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/quizApp/assets/css/pages/aut.css">
  <title>Register</title>
</head>

<body>
<!-- Cái form-message dùng để chứa mấy cái cảnh báo nếu m muốn hiện lên, ko cần thiết thì xóa đi cx dc-->
  <div class="main">
    <form action="../processing/register-processing.php" method="POST" class="form" id="form-1">

      <h3 class="heading">Register</h3>

      <div class="spacer"></div>

      
      <div class="form-group">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" type="text" placeholder="Username123" class="form-control" required autocomplete="off">
        <span class="form-message"></span> 
      </div>
      
      <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" placeholder="Enter your password..." class="form-control" required autocomplete="off">
        <span class="form-message"></span>
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="text" placeholder="email@domain.com" class="form-control" required autocomplete="off">
        <span class="form-message"></span>
      </div>

      <div class="form-group">
        <label for="birthday" class="form-label">Date of Birth</label>
        <input id="birthday" name="dob" type="date" class="form-control" required autocomplete="off">
        <span class="form-message"></span>
      </div>

      <div class="form-group">
        <label for="gender" class="form-label">Gender</label>
        <select id="gender" name="gender" class="form-control" required autocomplete="off">
          <option value="0">Male</option>
          <option value="1">Female</option>
        </select>
      </div>

      <div class="form-group">
        <label for="nationality" class="form-label">Nationality</label>
        <input id="nationality" name="nationality" type="text" placeholder="Type your nationality..." class="form-control" required autocomplete="off">
        <span class="form-message"></span>
      </div>      
      
      <button class="form-submit" type="submit">Register</button>
      <div class="link-login">
      <span>Already have an account? </span> <span><a href="/quizApp/login.php">Login</a></span>
    </div>
    </form>
    <div class="register-bg"><img src="/quizApp/assets/images/bg/login_theme.jpg" alt="bg"></div>

  </div>

</body>

</html>