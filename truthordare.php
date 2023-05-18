<?php
    $dsn = 'mysql:dbname=truthordare;host=localhost';
    $username = 'root';
    $password = '';
    
    $con = new PDO($dsn, $username, $password);
    
    $con->exec("CREATE TABLE IF NOT EXISTS players (id INT(8) NOT NULL AUTO_INCREMENT,name VARCHAR(255) NOT NULL,PRIMARY KEY (id))");
    $con->exec("CREATE TABLE IF NOT EXISTS dares (id INT(8) NOT NULL AUTO_INCREMENT,dare VARCHAR(255) NOT NULL,PRIMARY KEY (id))");
    $con->exec("CREATE TABLE IF NOT EXISTS truths (id INT(8) NOT NULL AUTO_INCREMENT,truth VARCHAR(255) NOT NULL,PRIMARY KEY (id))");

    if(isset($_POST["addplayer_btn"])) {
        global $con;
        $stmt = $con->prepare("INSERT INTO players(name) VALUES(:player)");
        $stmt->bindParam(":player", $_POST["playername_create"]);
        $stmt->execute();
        header("Refresh:0");
    }
    if(isset($_POST["addtruth_btn"])) {
        global $con;
        $stmt = $con->prepare("INSERT INTO truths(truth) VALUES(:truth)");
        $stmt->bindParam(":truth", $_POST["truth_create"]);
        $stmt->execute();
        header("Refresh:0");
    }
    if(isset($_POST["adddare_btn"])) {
        global $con;
        $stmt = $con->prepare("INSERT INTO dares(dare) VALUES(:dare)");
        $stmt->bindParam(":dare", $_POST["dare_create"]);
        $stmt->execute();
        header("Refresh:0");
    }
    if(isset($_POST["deleteuser"])) {
        global $con;
        $stmt = $con->prepare("DELETE FROM players WHERE id='".$_POST["deleteuser"]."'");
        $stmt->execute();
    }
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Truth or Dare?</title>
</head>
<style>

</style>
<body>
    <?php if(!isset($_GET["settings"])) { ?>
        <a style="top: 0;" class="position-absolute end-0 btn btn-dark" href="?settings=admin">Settings</a>
        <?php if(!isset($_GET["phase"])) { ?>
            <div class="position-absolute top-25 start-25">
                <a class="btn btn-success btn-rounded" href="?phase=pickplayer">Random Player</a>
            </div>
        <?php }else { if($_GET["phase"] == "pickplayer") { 
            global $con;
            $stmt = $con->prepare("SELECT * FROM players WHERE name NOT IN ('".$_SESSION["Player"]."') ORDER BY rand() limit 1");
            $stmt->execute();
            $fetchuser = $stmt->fetchAll();
            $_SESSION["Player"] = $fetchuser[0]["name"];
        ?>
        <div class="text-center">
            <p style="border: 4px outset rgb(175,126,118); top: 50px; position: relative"><?php echo $_SESSION["Player"].", it's your turn!";?></p>
        </div>
        <div style="top: 50px; position: relative;" class="text-center">
            <h1>What do you choose?</h1>
            <a href="?phase=truth" class="btn btn-info btn-lg">Truth</a>
            <h4>or</h4>
            <a href="?phase=dare" class="btn btn-danger btn-lg">Dare</a>
        </div>
        <?php }elseif($_GET["phase"] == "truth") {            
            global $con;
            $stmt = $con->prepare("SELECT * FROM truths ORDER BY rand() limit 1");
            $stmt->execute();
            $fetchuser = $stmt->fetchAll();
            $_SESSION["APhrase"] = $fetchuser[0]["truth"]; ?>
            <div class="text-center">
                <p style="top: 50px; position: relative;"><?php echo $_SESSION["Player"]." Your Question: "?></p>
                <p style="top: 50px; position: relative;"><?php echo "'". $_SESSION["APhrase"]."'"; ?></p>
                <a style="top: 50px; position: relative;" href="?phase=pickplayer" class="btn btn-success">Next Player</a>
            </div>
        <?php }elseif($_GET["phase"] == "dare") { 
            global $con;
            $stmt = $con->prepare("SELECT * FROM dares ORDER BY rand() limit 1");
            $stmt->execute();
            $fetchuser = $stmt->fetchAll();
            $_SESSION["APhrase"] = $fetchuser[0]["dare"]; ?>
            <div class="text-center">
                <p style="top: 50px; position: relative;"><?php echo $_SESSION["Player"]." Your Task: "?></p>
                <p style="top: 50px; position: relative;"><?php echo "'". $_SESSION["APhrase"]."'"; ?></p>
                <a style="top: 50px; position: relative;" href="?phase=pickplayer" class="btn btn-success">Next Player</a>
            </div>
        <?php } } ?>
    <?php }else{ ?>
    <?php if($_GET["settings"] == "admin") { ?>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
            <h1 class="text-center">User Settings[<a href="truthordare.php">Back</a>]</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Add Player</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" name="playername_create" placeholder="Player Name">
                                    <label for="floatingInput">Player Name</label>
                                </div><br>
                                <button name="addplayer_btn" class="btn btn-primary container" type="submit">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Add Truth Question</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" name="truth_create" placeholder="Truth Question">
                                    <label for="floatingInput">Truth Question</label>
                                </div><br>
                                <button name="addtruth_btn" class="btn btn-primary container" type="submit">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Add Dare Task</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInput" name="dare_create" placeholder="Dare Task">
                                    <label for="floatingInput">Dare Task</label>
                                </div><br>
                                <button name="adddare_btn" class="btn btn-primary container" type="submit">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><br>
            <h1 class="text-center">Database Content:</h1><br>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Player</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <ul>
                                        <form method="post">
                                            <?php 
                                                $stmt = $con->prepare("SELECT * FROM players");
                                                $stmt->execute();
                                                while($row = $stmt->fetch()){
                                            ?>
                                                <li><?php echo $row["name"]; ?><button name="deleteuser" type="submit" value="<?php echo $row["id"]; ?>">x</button></li>
                                            <?php } ?>
                                        </form>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Truth Questions</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <ul>
                                        <form method="post">
                                            <?php 
                                                $stmt = $con->prepare("SELECT * FROM truths");
                                                $stmt->execute();
                                                while($row = $stmt->fetch()){
                                            ?>
                                                <li><?php echo $row["truth"]; ?><button name="deleteuser" type="submit" value="<?php echo $row["id"]; ?>">x</button></li>
                                            <?php } ?>
                                        </form>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Dare Tasks</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating">
                                    <ul>
                                        <form method="post">
                                            <?php 
                                                $stmt = $con->prepare("SELECT * FROM dares");
                                                $stmt->execute();
                                                while($row = $stmt->fetch()){
                                            ?>
                                                <li><?php echo $row["dare"]; ?><button name="deleteuser" type="submit" value="<?php echo $row["id"]; ?>">x</button></li>
                                            <?php } ?>
                                        </form>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } } ?>
</body>
</html>
