<?php
    session_start();
    include_once 'config.php';
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$connection) {
        throw new Exception( "Cannot connect to database" );
    } else{
    $action = $_POST['action'] ?? '';
    $statusCode = 0;
    if('add'==$action) {
        $taskname = $_POST['taskname'];
        $taskdate = $_POST['taskdate'];
        $tasktags = $_POST['tasktags'];
        $user_id = $_SESSION['id']?? 0;
        if($taskname && $taskdate && $tasktags && $user_id){
            $sql = "INSERT INTO ". DB_TABLE ." (taskname, taskdate, tasktags, user_id) VALUES ('{$taskname}', '{$taskdate}', '{$tasktags}', '{$user_id}')";
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
    } else if ('register' == $action) {
        $username = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        if ($username && $password) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (email, password) VALUES ('{$username}', '{$hashPassword}')";
    
            try {
                $result = mysqli_query($connection, $query);
                
                if ($result) {
                    $statusCode = 5;
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    $statusCode = 4;
                } 
            }
        } else {
            $statusCode = 2;
        }
    
        header("Location: login.php?status={$statusCode}");
    }
    else if('login'==$action){
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if($username && $password){
        $query = "SELECT id, password FROM users WHERE email = '{$username}'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_id = $user['id'];
            if(password_verify($password, $user['password'])){
                $_SESSION['id'] = $_id;
                header('Location: index.php');
                return;

            }else{
                $statusCode = 3;
            }
        }else{
            $statusCode = 1;
        }
}else{
        $statusCode = 2;
    }
}
    header('Location: login.php?status='.$statusCode);
}
mysqli_close($connection);
