<!DOCTYPE html>
<html>
    <html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/signup.css">


</head>
<body>

    <div class="signup-box">

  <h2>Sign Up</h2>
  <form action="signup.php" method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Sign Up</button>
  </form>
  <p>Already have an account? <a href="login-form.php">Log In</a></p>

</body>
</html>
