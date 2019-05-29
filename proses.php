<?php
    session_start(); 
    $file = "data.json";
    $arr_data = array();

    //Start Upload Image
    $target_dir     = "uploads/";
    $target_file    = $target_dir . basename($_FILES["profile"]["name"]);
    $uploadOk       = 1;
    $imageFileType  = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    // if(isset($_POST["submit"])) {
    //     $check = getimagesize($_FILES["profile"]["tmp_name"]);
    //     if($check !== false) {
    //         $uploadOk = 1;
    //         $_SESSION['success_upload'] = "File is an image - " . $check["mime"] . "."; 
    //     } else {
    //         $uploadOk = 0;
    //         $_SESSION['error'] = "File is not an image.";
    //     }
    // }
    if ($_FILES["profile"]["error"] > 0) {
        $uploadOk = 0;
        $_SESSION['error'] = "Empty image!!";
        header("Location: index.php");
        return;
    }

    //check image size
    $fi = $_FILES["profile"]['tmp_name'];
    list($width, $height) = getimagesize($fi);

    if($width < "354" || $height < "472") {
        $_SESSION['error'] = "Image size must be 354 x 472 pixels (min) or then bigger";
        header("Location: index.php");
        return;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $_SESSION['error'] = "Sorry, file already exists.";
        header("Location: index.php");
        return;
    }

    // Check file size 5MB
    if ($_FILES["profile"]["size"] > 5000000) {
        $uploadOk = 0;
        $_SESSION['error'] = "Sorry, your file is too large.";
        header("Location: index.php");
        return;
    }
    // Allow certain file formats
    if( $imageFileType != "jpg" && $imageFileType != "jpeg" ) {
        $uploadOk = 0;
        $_SESSION['error'] = "Sorry, only JPG or JPEG files are allowed.";
        header("Location: index.php");
        return;
    }

    
    if(isset($_POST["submit"])) {
        //Get form data    
        $formdata = array(
                'firstname'  => strtoupper($_POST['firstname']),
                'middlename' => strtoupper($_POST['middlename']),
                'lastname'   => strtoupper($_POST['lastname']),
                'jabatan'    => strtoupper($_POST['jabatan']),
                'email'  	 => $_POST['email'],
                'phoneext'   => $_POST['phoneext'],
                'profile'    => $target_file,
                'jobdesc'    => ucfirst(strtolower($_POST['jobdesc'])),
                'motto'      => ucfirst(strtolower($_POST['motto']))
        );

        //Get data from existing json file
        $jsondata = file_get_contents($file);
        $arr_data = json_decode($jsondata, true);
        
        //Check Already Exist Data
        foreach ($arr_data["team"] as $key => $value) {
            if(in_array(ucfirst(strtolower($formdata["firstname"])), $value, true)){
                $_SESSION['error_validate'] = 'Data Already Exist!!'; 
                header("Location: index.php");
                return;
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0 || $_SESSION['error_validate'] <> '') {
            $_SESSION['error'] = "Sorry, your file was not uploaded.";
            return;
        } else {
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                $_SESSION['success_upload'] = "The file ". basename( $_FILES["profile"]["name"]). " has been uploaded.";
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                header("Location: index.php");
                return;
            }
        }

        //Cek kondisi json ketika awal masih kosong
        if($arr_data === NULL) {
            $arr_data["team"] = array($formdata);
        }
        else {
            array_push($arr_data["team"], $formdata);
        }
        
        //Convert updated array to JSON
        $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
            
        //write json data into data.json file
        if(file_put_contents($file, $jsondata)) {
            $_SESSION['success'] = "Data Successfully Saved!"; 
            header("Location: index.php");
            return;
        }
        else {
            $_SESSION['error'] = "Error Saved!"; 
            header("Location: index.php");
            return;
        }
    }

?>