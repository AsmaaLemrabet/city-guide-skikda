<?php
session_start();
session_unset();
session_destroy();

header("Location: index.php"); // or index.php if you convert later
exit();
