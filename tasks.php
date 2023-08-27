<?php
    include_once 'config.php';
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$connection) {
        throw new Exception( "Cannot connect to database" );
    } else{
    $action = $_POST['action'] ?? '';
    if('add'==$action) {
        $taskname = $_POST['taskname'];
        $taskdate = $_POST['taskdate'];
        $tasktags = $_POST['tasktags'];
        if($taskname && $taskdate && $tasktags){
            $sql = "INSERT INTO ". DB_TABLE ." (taskname, taskdate, tasktags) VALUES ('{$taskname}', '{$taskdate}', '{$tasktags}')";
            $result = mysqli_query($connection, $sql);
            if($result){
                echo $result;
                header('Location: index.php');
                return;
            }else{
                echo "Error: " . $sql . "<br>";
            }
        }else{
            echo "Please fill all the fields";
        }
    }
}
