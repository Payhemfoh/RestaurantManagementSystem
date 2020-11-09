<?php
    $function = $_POST['function'];
    $file = $_POST['file'];
    $log = array();

    switch($function){
        case("getState"):
            {
                if(file_exists($file)){
                    $lines = file($file);
                }
                $log['state'] = count($lines);
            }
        break;
        case("update"):
            {
                $state = $_POST['state'];
                if(file_exists($file)){
                    $lines = file($file);
                }
                $count = count($line);
                if($state == $count){
                    $log['state'] = $state;
                    $log['text'] = false;
                }else{
                    $text = array();
                    $log['state'] = $state + count($lines) - $state;
                    foreach($lines as $line_num => $line){
                        if($line_num > $state){
                            $text[] = str_replace("\n","",$line);
                        }
                    }
                    $log['text'] = $text;
                }
            }
        break;
        case("send"):
            {
                $username = htmlentities(strip_tags($_POST['username']));
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                $msg = htmlentites(strip_tags($_POST['message']));
                if($msg!='\n'){
                    if(preg_match($reg_exUrl,$msg,$url)){
                        $msg = preg_replace($reg_exUrl,"<a href='".$url[0]."'>".$url[0]."</a>",$msg);
                    }
                    $fileStream = fopen($file, 'a');
                    fwrite($fileStream, "<span>". $nickname . "</span>" . str_replace("\n", " ", $msg) . "\n"); 
                }
            }
        break;
    }

    echo json_encode($log);
?>