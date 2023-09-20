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
        $name = $_POST['username'] ?? '';
        $username = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $profile = $_FILES['profile'] ?? '';
    
        if ($name && $username && $password && $profile) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);

            $profileName = explode('.', $profile['name']);
            $profileExtension = strtolower(end($profileName));
            
            $uniqueProfileName = uniqid('profile_',true) . '.' . $profileExtension;
            $uploadProfile = move_uploaded_file($profile['tmp_name'], 'assets/img/profile/'. $uniqueProfileName);

            if (!$uploadProfile) {
                $statusCode = 6;
            }else{
                $userquery = "INSERT INTO `users` (`name`, `email`, `password`,`profile`) VALUES ('{$name}', '{$username}', '{$hashPassword}', '{$uniqueProfileName}')";
            }
    
            try {
                $result = mysqli_query($connection, $userquery);
                var_dump($result);
                
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
}else if('update_profile'==$action){
   if(isset($_POST['update_user'])){
    $name = $_POST['username'] ?? '';
    $username = $_POST['email'] ?? '';
    $profile = $_FILES['profile'] ?? '';

    if($name && $username){
        $query = "UPDATE users SET name = '{$name}', email = '{$username}'";
        $updated_user = mysqli_query($connection, $query);
        if($updated_user){
            $statusCode = 5;
        }else{
            $statusCode = 6;
        }
    }else{
        $statusCode = 2;
    }
   }

    
}
    header('Location: login.php?status='.$statusCode);
}
mysqli_close($connection);
