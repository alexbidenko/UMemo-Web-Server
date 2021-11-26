<?php
$mysqli = new mysqli("db", "umemo_server", "server_umemo", "umemo_database");

$create_keeps_json = [];

$result = $mysqli->query("SELECT * FROM keeps_table_".$_POST['login']."_".$_POST['pass'].";");

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['color_keep'] != 0) {
            $create_keeps_json[$row['keep_name']]['table_keep_text'] = array();
            $create_keeps_json[$row['keep_name']]['keep_next_event'] = $row['keep_next_event'];
            $create_keeps_json[$row['keep_name']]['keep_params'] = json_encode((object)[
                    'color_keep' => (int)$row['color_keep'], 
                    'font_family_number_keep' => (int)$row['font_family_number_keep'], 
                    'font_family_path_keep' => $row['font_family_path_keep'], 
                    'text_size_keep' => (int)$row['text_size_keep'], 
                    'date_redact' => $row['date_redact']
                ], JSON_PRETTY_PRINT);
        } else {
            $create_keeps_json[$row['keep_name']] = null;
        }
    }
}

$result = $mysqli->query("SELECT * FROM keeps_text_".$_POST['login']."_".$_POST['pass'].";");

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($create_keeps_json[$row['keep_name']]['table_keep_text'], 
            array(
                $row['keep_type_of_data'], 
                $row['keep_value_of_data']
            ));
    }
}

echo json_encode((object)$create_keeps_json, JSON_PRETTY_PRINT);
?>