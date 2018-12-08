<?php

if(isset($_POST["user_id"])) {
    include 'includes/dbh.inc.php'; 
        $user_id = $_POST["user_id"];
        $result = $conn->query("delete from users where user_id = '$user_id'");

        if($result) {
            header("Location: register.php?success");
            exit();
        }
   
}else{
    header("Location: register.php?failed");
    exit();
}

?>