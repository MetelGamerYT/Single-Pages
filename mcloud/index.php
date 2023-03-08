<?php
if(isset($_POST["submit"])) {
    if(isset($_FILES["content"]) && $_FILES["content"]["error"] == 0){

      $file = $_FILES['content']['name'];
      $file_loc = $_FILES['content']['tmp_name'];
      $file_size = $_FILES['content']['size'];
      $file_type = $_FILES['content']['type'];
      $folder = 'data/';

      $new_file_name = strtolower($file);
      $final_file=str_replace(' ', '-', $new_file_name);
      if(move_uploaded_file($file_loc,$folder.$final_file)) {
        header("Refresh:0");
      }else{
        echo "Error: File could'nt moved!";
      }
    }else {
      echo "Error: no File!";
    }
}

if(isset($_POST["delete"])) {
    unlink("data/".$_POST["delete"]);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MetelCloud - Version 1.0</title>
</head>
<style>
    body {
        text-align: center;
    }
    .upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }
    .button {
        background: none!important;
        border: none;
        padding: 0!important;
        font-family: arial, sans-serif;
        color: #069;
        text-decoration: underline;
        cursor: pointer;
    }
    .listfile {
        list-style-type: none;
    }
</style>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <h1>MetelCloud - Upload your Stuff</h1>
        <input id="content" name="content" type="file" accept=".zip,.7z," class="upload">
        <button name="submit">Upload</button>
        <hr>

        <div class="center">
            <!-- Search Area -->
            <input type="text" placeholder="Search File.." id="searchbar" style="margin-bottom: 5px;">
            <br>
            <a onclick="" href=""></a>
            <?php
                $dir = "data/";
                $all = array_diff(scandir($dir), [".", ".."]);
                $eol = PHP_EOL;
                
                foreach ($all as $ff) { ?>
                    <li class="listfile"><?php echo "<b> {$ff} {$eol} </b> - " ?> <a href="data/<?php echo $ff?>"><i class="fa-solid fa-download"></i></a> 
                    <button name="delete" value="<?php echo $ff ?>" class="button"><i class="fa-solid fa-trash-can"></i></button> <?php echo "<br>" ?></li>
                <?php }
            ?>
        </div>
    </form>
    <script src="https://kit.fontawesome.com/b7c91fdb59.js" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#searchbar").addEventListener("input", filterList)
        function filterList(){
            const sinput = document.querySelector("#searchbar")
            const filter = sinput.value.toLowerCase()
            const listItems = document.querySelectorAll('.listfile')
            listItems.forEach((item) =>{
                let text = item.textContent;
                if(text.toLowerCase().includes(filter.toLowerCase())) {
                    item.style.display = '';
                }else{
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>