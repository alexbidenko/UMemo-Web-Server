<?php
$mysqli = new mysqli("db", "umemo_server", "server_umemo", "umemo_database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
    
if(!$mysqli->query("DELETE FROM keeps_table_".$_POST['login']."_".$_POST['pass'].";") ||
    !$mysqli->query("DELETE FROM keeps_text_".$_POST['login']."_".$_POST['pass'].";"))
{
    echo "Не удалось удалить таблицы: (" . $mysqli->errno . ") " . $mysqli->error."\n";
}

foreach (json_decode($_POST['keepData'], true) as $keepName => $keep) {
    if($keep != null) {
        
        $keep_params_json = json_decode(str_replace("'", '"', $keep['keep_params']), true);
        
        $color_keep;
        if ($keep_params_json['color_keep'] > 0) {
            switch($keep_params_json['color_keep']) {
                case 0x7f060039:
                    $color_keep = -1;
                    break;
                case 0x7f060034:
                    $color_keep = -2;
                    break;
                case 0x7f06002f:
                    $color_keep = -3;
                    break;
                case 0x7f06003a:
                    $color_keep = -4;
                    break;
                case 0x7f06002d:
                    $color_keep = -5;
                    break;
                case 0x7f06002e:
                    $color_keep = -6;
                    break;
                case 0x7f06002b:
                    $color_keep = -7;
                    break;
                case 0x7f060033:
                    $color_keep = -8;
                    break;
                case 0x7f06002c:
                    $color_keep = -8;
                    break;
                default:
                    $color_keep = -1;
                    break;
            }
        } else {
            $color_keep = $keep_params_json['color_keep'];
        }
        
        if(!$mysqli->query("INSERT INTO keeps_table_".$_POST['login']."_".$_POST['pass']." 
            (
                keep_name, 
                color_keep, 
                font_family_number_keep, 
                font_family_path_keep, 
                text_size_keep, 
                date_redact, 
                keep_next_event
            ) 
            VALUES 
            (
                '".$keepName."', 
                ".$color_keep.", 
                ".$keep_params_json['font_family_number_keep'].", 
                '".$keep_params_json['font_family_path_keep']."', 
                ".$keep_params_json['text_size_keep'].", 
                '".$keep_params_json['date_redact']."', 
                '".$keep['keep_next_event']."'
            );"))
        {
            echo "Не удалось обновить таблицу данных: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        }
            
        if (gettype($keep['table_keep_text']) == "string") {
            $keep['table_keep_text'] = json_decode($keep['table_keep_text'], true);
        }
        
        foreach ($keep['table_keep_text'] as $keep_row) {
            
            if(!$mysqli->query("INSERT INTO keeps_text_".$_POST['login']."_".$_POST['pass']." 
                (
                    keep_name, 
                    keep_type_of_data, 
                    keep_value_of_data
                ) 
                VALUES 
                (
                    '".$keepName."', 
                    '".$keep_row[0]."', 
                    '".$keep_row[1]."'
                );"))
            {
                echo "Не удалось обновить таблицу текстов: (" . $mysqli->errno . ") " . $mysqli->error."\n";
            }
            
        }
    } else {
        if(!$mysqli->query("INSERT INTO keeps_table_".$_POST['login']."_".$_POST['pass']." 
            (
                keep_name, 
                color_keep
            ) 
            VALUES 
            (
                '".$keepName."', 
                0
            );"))
        {
            echo "Не удалось удалить заметку: (" . $mysqli->errno . ") " . $mysqli->error."\n";
        }
    }
}
?>