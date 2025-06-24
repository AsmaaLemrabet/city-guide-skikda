<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <link rel="stylesheet" href="css/login.css">

</head>
<body>
  <div class="login-box">
    <h2>🔐 Log In</h2>

    <?php if (isset($_GET['error'])): ?>
  <div style="color: red; font-weight: bold; margin-bottom: 10px;">
    ❌ Wrong email or password.
  </div>
<?php endif; ?>

    <form action="login.php" method="post">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">➡️ Log In</button>
    </form>
    <p>Don't have an account? <a href="signup-form.php">Sign Up</a></p>
  </div>
</body>
</html>
