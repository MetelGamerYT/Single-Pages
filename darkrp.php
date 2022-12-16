<?php
    $dsn = 'mysql:dbname=darkrp;host=localhost';
    $username = 'root';
    $password = '';
    
    $con = new PDO($dsn, $username, $password);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DarkRP - Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container table-responsive py-5"> 
    <table class="table table-dark table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
        <th scope="col">Player</th>
        <th scope="col">Money</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $stmt = $con->prepare("SELECT * FROM darkrp_player WHERE length(uid) > 11 ORDER BY wallet DESC LIMIT 50");
            $stmt->execute();
            while($row = $stmt->fetch()){
        ?>
        <tr>
            <td><?php echo $row["rpname"] ?></td>
            <td><?php echo number_format($row["wallet"], 2, ',', '.')."$"; ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>
    </div>
</body>
</html>
