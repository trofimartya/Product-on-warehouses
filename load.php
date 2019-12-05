<?php

// Указываем путь к файлу сохранения данных 
$file = 'info.json';
$decode = (array)json_decode(file_get_contents($file));

// $_FILES сохранит информацию загруженную через форму
$name = $_FILES['csv']['name'];  
    $csv = array();
    // Разобьем строки созданного массива
    $ext = explode('.', $_FILES['csv']['name'])[1];
    $tmpName = $_FILES['csv']['tmp_name'];
    // Проверка корректной загрузки файла
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r'))) {
            while(($data = fgetcsv($handle, 0))) {  
                array_push($csv, $data);
            }
            fclose($handle);
        }
    }

$title = [];
$tmp = [];
$data_unset = [];
foreach ($decode as $key => $value) {
    array_push($title, $value[0].'-'.$value[2]);
}

// Скрипт вычисления продуктов на складах
foreach ($decode as $currKey => $curr) {
    foreach ($csv as $newKey => $new) {
        if($curr[0] === $new[0]){
            if($curr[2] === $new[2]){
                // Плюсуем кол-ство продуктов и отображаем результат
                if($curr[1] + $new[1] > 0){ 
                    array_push($tmp, [$curr[0], $curr[1] + $new[1], $curr[2]]);
                    unset($csv[$newKey]);
                }else{
                    array_push($data_unset, $currKey);
                }
                }else{
                    if(in_array($new[0].'-'.$new[2], $title)){
                        if($new[1] > 0){
                        array_push($tmp, $new);
                        unset($csv[$newKey]);
                    }
                }   
            }
        }else{
            // Проверяем значение товаров на > 0
            if(!in_array($new[0].'-'.$new[2], $title)){
                if($new[1] > 0){
                    array_push($tmp, $new);
                  unset($csv[$newKey]);
                } 
            }
        }
    }      
        // Удаляем повторение данных  
        $temp = 0;
        foreach ($tmp as $key => $value) {
            if($curr[0] == $value[0]){
                $temp = 1;
            }
        }
        if($temp == 0){
            if(!in_array($currKey, $data_unset)){
                array_push($tmp, $curr);
                unset($decode[$currKey]);
            }   
        }
    }

// Сохраняем данные
file_put_contents($file, json_encode((object)$tmp));
header('Location: index.php');



