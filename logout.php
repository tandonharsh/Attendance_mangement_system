
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout Page</title>

</head>
<body>
        <?php
        session_start();

        session_unset();
        $success=session_destroy();
        
        ?>
<script>
        alert("You have logged out successfully 👍 Thanks for visiting 😁");
        window.location.href = "index.php";
</script>
</body>
</html>
