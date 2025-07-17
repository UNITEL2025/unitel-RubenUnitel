<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>title</title>
</head>
<body>
    <p>Variables:</p>
    <p><?php 
        if (isset($_SESSION["var1"]))
            echo $_SESSION["var1"];
        else
            echo "No existe";
        ?></p>
</body>
</html>