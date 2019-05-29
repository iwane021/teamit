<?php
session_start();

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $jsondata = file_get_contents('data.json');
    $getjson = json_decode($jsondata, true);
    $getjson = $getjson["team"];
    $getjson = $getjson[$id];
}

if (isset($_POST["id"])) {
    $id = (int) $_POST["id"];
    $jsondata = file_get_contents('data.json');
    $all = json_decode($jsondata, true);
    $getjson = $all["team"];
    $getjson = $getjson[$id];

    $post["firstname"] = isset($_POST["firstname"]) ? strtoupper($_POST['firstname']) : "";
    $post["middlename"] = isset($_POST["middlename"]) ? strtoupper($_POST['middlename']) : "";
    $post["lastname"] = isset($_POST["lastname"]) ? strtoupper($_POST['lastname']) : "";
    $post["jabatan"] = isset($_POST["jabatan"]) ? strtoupper($_POST['jabatan']) : "";
    $post["email"] = isset($_POST["email"]) ? $_POST['email'] : "";
    $post["profile"] = isset($_POST["profile"]) ? $_POST['profile'] : "";
    $post["phoneext"] = isset($_POST["phoneext"]) ? $_POST['phoneext'] : "";
    $post["jobdesc"] = isset($_POST["jobdesc"]) ? ucfirst($_POST['jobdesc']) : "";
    $post["motto"] = isset($_POST["motto"]) ? ucfirst($_POST['motto']) : "";
    
    if ($getjson) {
        unset($all["team"][$id]);
        $all["team"][$id] = $post;
        $all["team"] = array_values($all["team"]);
        
        $jsondata = json_encode($all, JSON_PRETTY_PRINT);
        // file_put_contents("data.json", json_encode($all, JSON_PRETTY_PRINT));
        //write json data into data.json file
        if(file_put_contents("data.json", $jsondata)) {
            $_SESSION['success'] = "Edit Data Successfully!"; 
            header("Location: index.php");
            return;
        }
        else {
            $_SESSION['error'] = "Error!"; 
            header("Location: index.php");
            return;
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Team IT</title>
        <link rel="stylesheet" href="styles.css" >
    </head>
<body>
<div id="container">
    <header>
        <!-- <h1>Form Isian Untuk Web IT</h1> -->
    </header>
    <div class="marquee">
        <p>Berikut ini contoh form inputan untuk memanage Tim IT. Untuk perintah crud ini saya buat hanya menggunakan file json, tanpa database. Silahkan dikembangkan sesuai kebutuhan anda masing-masing</p>
    </div>

    <?php if(isset($_SESSION['success'])) { ?>
        <div id="success" class="success-msg">&nbsp;&nbsp;<?php echo $_SESSION['success']; ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])) { ?>
        <div id="error" class="error-msg">&nbsp;&nbsp;<?php echo $_SESSION['error']; ?></div>
    <?php } ?>

    <?php if (isset($_GET["id"])): ?>
    <form id="formDetail" action="edit.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Form Details</legend>
            <div class="box-content">
                <div class="left">
                    <div>
                        <label>Nama (required):</label>
                        <input type="hidden" value="<?php echo $id ?>" name="id"/>
                        <input type="text" id="firstname" maxlength="15" name="firstname" value="<?php echo ucfirst(strtolower($getjson["firstname"])); ?>" placeholder="Firstname" required>
                    </div>
                    <div>
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" id="middlename" maxlength="20" name="middlename" value="<?php echo ucfirst(strtolower($getjson["middlename"])); ?>" placeholder="Middlename">
                    </div>
                    <div>
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" id="lastname" maxlength="20" name="lastname" value="<?php echo ucfirst(strtolower($getjson["lastname"])); ?>" placeholder="Lastname" required>
                    </div>
                    <div>
                        <label>Jabatan (required):</label>
                        <input type="text" id="jabatan" maxlength="30" name="jabatan" value="<?php echo ucfirst(strtolower($getjson["jabatan"])); ?>" placeholder="Jabatan">
                    </div>
                    <div>
                        <label for="email">Email (required):</label>
                        <input type="text" id="email" name="email" value="<?php echo $getjson["email"]; ?>" placeholder="rasmus.lerdorf@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div>
                        <label for="phoneext">Phone Ext (optional):</label>
                        <input type="hidden" id="profile" name="profile" value="<?php echo $getjson["profile"]; ?>">
                        <input type="text" id="phoneext" maxlength="4" name="phoneext" value="<?php echo $getjson["phoneext"]; ?>" placeholder="Ex:1648" pattern="[0-9]{4}">
                    </div>
                </div>
                <div class="right">
                    <div class="fieldtextarea">
                        <label for="jobdesc">Jobdesc (required):</label>
                        <textarea class="txtarea" maxlength="250" name="jobdesc"><?php echo $getjson["jobdesc"]; ?></textarea>
                    </div>
                    <div class="fieldtextarea">
                        <label for="motto">Motto (required):</label>
                        <textarea class="txtarea" maxlength="250" name="motto"><?php echo $getjson["motto"]; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="submit">
                <input type="submit" value="Submit">
                <input type="button" onclick="location.href='listdata.php'" value="Back">
            </div>
        </fieldset>
    </form>
    <?php endif; ?>
    <footer>
        &copy; Copyright - IT Team 2019
    </footer>
</div>

<script type='text/javascript'>
    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output_image');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script>
    function elm(id) {
        var el = document.getElementById(id);
        el.className += ' inactive';
        el.style.margin = 0;
        el.style.padding = 0;
        el.style.height = 0;
        
        return el;
    }

    var info = function() { elm("info"); }
    var success = function() { elm("success"); }
    var warning = function() { elm("warning"); }
    var error = function() { elm("error"); }
    
    window.onload = function() { 
        setTimeout(info, 2000);
        setTimeout(success, 3000); 
        setTimeout(warning, 4000); 
        setTimeout(error, 5000); 
        <?php 
            unset($_SESSION['success']);
            unset($_SESSION['error']);
        ?>
        document.getElementById("formDetail").reset();
    }
</script>
</body>
</html>