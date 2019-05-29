<?php
    session_start();

    $url = $_SERVER['REQUEST_URI'];
    $x = pathinfo($url);
    if($x["dirname"] !== '/teamit'){
        $last = '/'.$x["basename"];
    }else{
        $last = $x["dirname"];
    }
    $CurrentUrl = 'http://'.$_SERVER['HTTP_HOST'].$last;
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

    <?php if(isset($_SESSION['success_upload'])) { ?>
        <div id="info" class="info-msg">&nbsp;&nbsp;<?php echo $_SESSION['success_upload']; ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['success'])) { ?>
        <div id="success" class="success-msg">&nbsp;&nbsp;<?php echo $_SESSION['success']; ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['error_validate'])) { ?>
        <div id="warning" class="warning-msg">&nbsp;&nbsp;<?php echo $_SESSION['error_validate']; ?></div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])) { ?>
        <div id="error" class="error-msg">&nbsp;&nbsp;<?php echo $_SESSION['error']; ?></div>
    <?php } ?>

    <form action="proses.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Form Details</legend>
            <div class="box-content">
                <div class="left">
                    <div>
                        <label>Nama (required):</label>
                        <input type="text" id="firstname" maxlength="15" name="firstname" placeholder="Firstname" required>
                    </div>
                    <div>
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" id="middlename" maxlength="20" name="middlename" placeholder="Middlename">
                    </div>
                    <div>
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" id="lastname" maxlength="20" name="lastname" placeholder="Lastname">
                    </div>
                    <div>
                        <label>Jabatan (required):</label>
                        <input type="text" id="jabatan" maxlength="30" name="jabatan" placeholder="Jabatan">
                    </div>
                    <div>
                        <label for="email">Email (required):</label>
                        <input type="text" id="email" name="email" placeholder="rasmus.lerdorf@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div>
                        <label for="phoneext">Phone Ext (optional):</label>
                        <input type="number" id="phoneext" name="phoneext" placeholder="Ex:1648">
                    </div>
                    <div>
                        <label for="profile">Profile (required):</label>
                        <input class="profile" name="profile" type="file" accept="image/*" onchange="preview_image(event)">
                        <label>&nbsp;&nbsp;&nbsp;</label>
                        <img id="output_image"/>
                    </div>
                </div>
                <div class="right">
                    <div class="fieldtextarea">
                        <label for="jobdesc">Jobdesc (required):</label>
                        <textarea class="txtarea" maxlength="250" name="jobdesc"></textarea>
                    </div>
                    <div class="fieldtextarea">
                        <label for="motto">Motto (required):</label>
                        <textarea class="txtarea" maxlength="250" name="motto"></textarea>
                    </div>
                </div>
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Submit">
            </div>
        </fieldset>
    </form>
    <div class="links">
        <p><a href="<?php echo $CurrentUrl.'/listdata.php'; ?>">View Detail Team >></a></p>
    </div>
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
        setTimeout(success, 2500); 
        setTimeout(warning, 3000); 
        setTimeout(error, 3500); 
        <?php 
            unset($_SESSION['success_upload']);
            unset($_SESSION['success']);
            unset($_SESSION['error_validate']);
            unset($_SESSION['error']);
        ?>
    }
</script>
</body>
</html>