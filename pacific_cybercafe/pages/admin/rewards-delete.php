<?php

if(isset($_POST["reward_id"])) {
    include 'includes/dbh.inc.php'; 
        $reward_id = $_POST["reward_id"];
        $result = $conn->query("delete from rewards where reward_id = '$reward_id'");

        if($result) {
            header("Location: rewards.php?delete=success");
            exit();
        }
   
}else{
    header("Location: rewards.php?failed");
    exit();
}

?>