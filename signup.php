<?php 
include_once 'function.php';
session_start();
$user_id = $_SESSION['id'] ?? 0;
if($user_id){
    header('Location: index.php');
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
</head>
<body>

<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
  <div class="mx-auto max-w-lg text-center">
    <h1 class="text-2xl font-bold sm:text-3xl">Get started today!</h1>
    <p class="mt-4 text-gray-500">TaskMaster is your productivity partner, simplifying task management for work and life. Prioritize, track, and conquer tasks seamlessly.</p>
  </div>

  <form enctype="multipart/form-data" method="POST" action="tasks.php" class="mx-auto mb-0 mt-8 max-w-md space-y-4">
    <div>
      <label for="username" class="sr-only">Name</label>
      <div class="relative">
        <input type="name" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" placeholder="Enter name" name="username"/>
      </div>
    </div>

    <div>
      <label for="email" class="sr-only">Email</label>
      <div class="relative">
        <input type="email" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" placeholder="Enter email" name="email"/>
      </div>
    </div>

    <div>
      <label for="password" class="sr-only">Password</label>
      <div class="relative">
        <input type="password" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" placeholder="Enter password" name="password"/>
      </div>
    </div>

    <div>
      <label for="profile" class="sr-only">Profile Photo</label>
      <div class="relative">
        <input type="file" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" name="profile"/>
      </div>
    </div>

    <?php 
    $status = $_GET['status'] ?? 0;
    if ($status) {
        ?>
        <div>
        <?php 
        if($status == 5){
            ?>
            <p class="text-sm text-green-500">
                <?php echo getStatusMessage($status); ?>
            </p>
            <?php
        }else{ 
            ?>
            <p class="text-sm text-red-500">
                <?php echo getStatusMessage($status); ?>
            </p>
            <?php
        }
        ?>
        </div>
        <?php
    }
    ?>

    <div class="flex items-center justify-between">
      <p class="text-sm text-gray-500">
        Already Sign In?
        <a id="loginButton" class="underline" href="login.php">Log In</a>
      </p>
      <input id="signupButton" type="submit" value="Sign Up"class="inline-block rounded-lg bg-black px-5 py-3 text-sm font-medium text-white cursor-pointer hover:bg-blue-600 transition">
      <input id="actionField" type="hidden" name="action" value="register">
    </div>
  </form>
</div>
</body>
</html>