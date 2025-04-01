<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styleadmincp.css">
    <title>Admincp</title>
</head>
<body>
    <h3 class="title_admin">Welcome to AdminCP</h3>
    <div class="khoingoaicung">
<?php
       /*-- phải để lần lượt ở trong file chạy --*/
        include("modules/header.php");
        include("modules/menu.php");
        include("modules/main.php");
        include("modules/footer.php");
       ?>
       </div>

</body>
</html>