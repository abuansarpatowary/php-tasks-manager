<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
</head>
<body>

<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
  <div class="mx-auto max-w-lg text-center">
    <h1 class="text-2xl font-bold sm:text-3xl">Get started today!</h1>
    <p class="mt-4 text-gray-500">TaskMaster is your productivity partner, simplifying task management for work and life. Prioritize, track, and conquer tasks seamlessly. Boost efficiency, meet deadlines, and achieve your goals effortlessly. Embrace organized success today.</p>
  </div>

  <form action="" class="mx-auto mb-0 mt-8 max-w-md space-y-4">
    <div>
      <label for="email" class="sr-only">Email</label>
      <div class="relative">
        <input type="email" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" placeholder="Enter email"/>
      </div>
    </div>

    <div>
      <label for="password" class="sr-only">Password</label>
      <div class="relative">
        <input type="password" class="w-full rounded-lg border border-gray-400 p-4 pe-12 text-sm shadow-sm" placeholder="Enter password"/>
      </div>
    </div>

    <div class="flex items-center justify-between">
      <p class="text-sm text-gray-500">
        No account?
        <a class="underline" href="">Sign up</a>
      </p>

      <input type="submit" value="Login"class="inline-block rounded-lg bg-black px-5 py-3 text-sm font-medium text-white cursor-pointer hover:bg-blue-600 transition">
    </div>
  </form>
</div>
</body>
</html>