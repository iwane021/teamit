<?php
session_start();

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $jsondata = file_get_contents('data.json');
    $all = json_decode($jsondata, true);
    $getjson = $all["team"];
    $getjson = $getjson[$id];

    if ($getjson) {
		//delete file in folder
		if (file_exists($getjson["profile"])) {
			unlink($getjson["profile"]);
		}
        unset($all["team"][$id]);
        $all["team"] = array_values($all["team"]);
        
        $jsondata = json_encode($all, JSON_PRETTY_PRINT);
        
        //write json data into data.json file
        if(file_put_contents("data.json", $jsondata)) {
            $_SESSION['success'] = "Delete Data Successfully!"; 
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