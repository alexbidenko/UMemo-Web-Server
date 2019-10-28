<?php
$mysqli = new mysqli("81.90.180.128", "umemo_server", "server_umemo", "umemo_database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "sdkmdj";
}

/*if($_POST['comand'] == "set") {
    $mysqli->query("INSERT INTO secret_messager 
            (
                from_who,
                to_who,
                message
            ) 
            VALUES 
            (
                '".$_POST['from_who']."',
                '".$_POST['to_who']."',
                '".$_POST['message']."'
            );");
            
    echo "ready";
} else if ($_POST['comand'] == "get") {
    $result = $mysqli->query("SELECT * FROM secret_messager WHERE from_who = '".$_POST['user']."' OR to_who = '".$_POST['user']."';");
    
    $ans;
    $count = 0;
    
    while($row = $result->fetch_assoc()) {
        if($count != 0) $ans += "\n";
        $ans += $row['from_who'].".".$row['to_who'].".".$row['message'];
        $count++;
    }
    
    echo $ans;
}*/
?>