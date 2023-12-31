<?php
    session_start();
    $user_id = $_SESSION['id'] ?? 0;
    if(!$user_id){
        header('Location: login.php');
        return;
    }
    include_once 'config.php';
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$connection) {
        throw new Exception( "Cannot connect to database" );
    }
    $search = $_GET['search'] ?? '';
    if($search){
        $query = "SELECT * FROM  " . DB_TABLE . " WHERE user_id = {$user_id} AND taskname LIKE '%{$search}%'";
    }else{
        $query = "SELECT * FROM  " . DB_TABLE . " WHERE user_id = {$user_id}";
    }
    $result = mysqli_query($connection, $query);
    // query for get users data
    $userquery = "SELECT * FROM  users WHERE id = {$user_id}";
    $userresult = mysqli_query($connection, $userquery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Tasks Manager with Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css"  rel="stylesheet" />

</head>
<body>
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="index.php" class="flex items-center ml-2 md:mr-24">
          <img src="../assets/img/logo.svg" alt="taskmaster logo">
          <span class="font-bold">Task Master</span>
        </a>
      </div>

      <div class="flex items-center">
          <div class="flex items-center ml-3">
          <?php 
                while($userdata = mysqli_fetch_assoc($userresult)){
              ?>

            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Open user menu</span>
                <!-- if not profile image then show default image -->
                <?php if(!$userdata['profile']){ ?>
                  <img class="w-8 h-8 rounded-full" src="assets/img/default.svg" alt="user photo">
                <?php }else{ ?>
                <img class="w-8 h-8 rounded-full" src="assets/img/profile/<?php echo $userdata['profile'] ?>" alt="user photo">
                <?php } ?>
              </button>
            </div>
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                  <?php echo $userdata['name'] ?>
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                  <?php echo $userdata['email'] ?>
                </p>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                </li>
                <li>
                  <a href="task.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                </li>
                <li>
                  <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                </li>
              </ul>
            </div>

          </div>
        </div>

    </div>
  </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ml-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group menu-item" data-target="task-wrapper">
            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Dask</title><path d="m11.246 9.754 5.848-3.374a.202.202 0 0 0 .1-.175l.002-2.553c0-.324-.133-.645-.392-.841a1 1 0 0 0-1.118-.074l-2.425 1.4-6.436 3.712a1.007 1.007 0 0 0-.504.872l-.003 8.721v2.825c0 .324.132.645.39.842.335.253.766.278 1.12.074l2.363-1.364a.202.202 0 0 0 .101-.175l.003-8.244a1.902 1.902 0 0 1 .951-1.646Zm10.316-4.336a1.005 1.005 0 0 0-.504-.137.997.997 0 0 0-.503.137l-8.86 5.112a1.01 1.01 0 0 0-.505.87l-.003 11.591c0 .364.188.69.503.872a.995.995 0 0 0 1.007 0l8.86-5.112a1.01 1.01 0 0 0 .504-.872l.004-11.59a.997.997 0 0 0-.503-.871ZM6.378 7.074l6.334-3.655a.202.202 0 0 0 .1-.175l.001-2.193c0-.324-.133-.646-.392-.84a1 1 0 0 0-1.118-.075L2.443 5.25a1.007 1.007 0 0 0-.504.872l-.003 11.546c0 .324.133.645.39.842a1 1 0 0 0 1.12.074l1.877-1.082a.202.202 0 0 0 .1-.175l.003-8.605c0-.68.363-1.307.952-1.647z"/></svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Tasks</span>
            </a>
         </li>
         <li>
            <a href="tasks.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group menu-item">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                  <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">User</span>
            </a>
         </li>
         <li>
            <a href="logout.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                  <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                  <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Sign Out</span>
            </a>
         </li>
      </ul>
   </div>
</aside>
<div class="mx-auto mt-12 max-w-6xl px-4 md:px-6 lg:px-8">

<div id="task-wrapper">
  <!-- form -->
  <div class="pt-8">
    <h2 class="text-3xl mb-2">Add Task</h2>
  <form method="POST" action="tasks.php" class="space-y-4">
          <div>
            <label class="sr-only" for="taskname">Task Name</label>
            <input
              class="w-full rounded-lg border border-gray-200 p-3 text-sm"
              placeholder="Tasks Details"
              type="text"
              id="taskname"
              name="taskname"
            />
          </div>
          <div>
            <label class="sr-only" for="taskdate">Task Date</label>
            <input
              class="w-full rounded-lg border border-gray-200 p-3 text-sm"
              placeholder="Tasks Date"
              type="date"
              id="taskdate"
              name="taskdate"
            />
          </div>
          
          <div class="mt-4">
            <label class="sr-only" for="tasktags">Task Tags</label>
            <input
              class="w-full rounded-lg border border-gray-200 p-3 text-sm"
              placeholder="Tasks Tags"
              type="text"
              id="tasktags"
              name="tasktags"
            />
          </div>
          <div class="mt-4 bg-[#050708] inline-block rounded-lg">
            <input
              type="submit"
              value="Add Task"
              class="w-full px-5 py-3 font-medium text-white sm:w-auto cursor-pointer"
            />
          </div>
          <div>
            <input type="hidden" name="action" value="add">
          </div>
  </form>
</div>
<div class="flex justify-between mt-7 pb-8">
    <div>
    <h2 class="text-3xl py-2">Task Manager</h2>
    
    </div>
    <?php 
      if(mysqli_num_rows($result) == 0){
        ?>
        <p>No Data Found</p>
        <?php
      }else{
    ?>
    <div>
      <form class="flex items-end">   
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Dask</title><path d="m11.246 9.754 5.848-3.374a.202.202 0 0 0 .1-.175l.002-2.553c0-.324-.133-.645-.392-.841a1 1 0 0 0-1.118-.074l-2.425 1.4-6.436 3.712a1.007 1.007 0 0 0-.504.872l-.003 8.721v2.825c0 .324.132.645.39.842.335.253.766.278 1.12.074l2.363-1.364a.202.202 0 0 0 .101-.175l.003-8.244a1.902 1.902 0 0 1 .951-1.646Zm10.316-4.336a1.005 1.005 0 0 0-.504-.137.997.997 0 0 0-.503.137l-8.86 5.112a1.01 1.01 0 0 0-.505.87l-.003 11.591c0 .364.188.69.503.872a.995.995 0 0 0 1.007 0l8.86-5.112a1.01 1.01 0 0 0 .504-.872l.004-11.59a.997.997 0 0 0-.503-.871ZM6.378 7.074l6.334-3.655a.202.202 0 0 0 .1-.175l.001-2.193c0-.324-.133-.646-.392-.84a1 1 0 0 0-1.118-.075L2.443 5.25a1.007 1.007 0 0 0-.504.872l-.003 11.546c0 .324.133.645.39.842a1 1 0 0 0 1.12.074l1.877-1.082a.202.202 0 0 0 .1-.175l.003-8.605c0-.68.363-1.307.952-1.647z"></path></svg>
            </div>
            <input type="text" name="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Task" required>
        </div>
        <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span class="sr-only">Search</span>
        </button>
    </form>
    </div>
  </div>
  <div class="overflow-x-auto">
  <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
    <thead>
      <tr>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 flex">
          <input
            type="checkbox"
            id="SelectAll"
            class="h-5 w-5 mr-2 rounded border-gray-300"
            onclick="toggleSelectAll()"
          />
          <label for="SelectAll">Select All</label>
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
        Task Name
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
          Date
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
          Tags
        </td>
      </tr>
    </thead>
    
    <?php 
        while($data = mysqli_fetch_assoc($result)){
    ?>
    <tbody class="divide-y divide-gray-200">
      <tr>
        <td class="sticky inset-y-0 start-0 bg-white px-4 py-2">
          <label class="sr-only" for="Row1">Row 1</label>

          <input
            class="h-5 w-5 rounded border-gray-300"
            type="checkbox"
            id="Row1"
          />
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
        <?php echo $data['taskname'] ?>
        </td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $data['taskdate'] ?></td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700"><?php echo $data['tasktags'] ?></td>
        <td class="whitespace-nowrap px-4 py-2">
          <a
            href="edit_task.php?id=<?php echo $data['id'] ?>"
            class="inline-block rounded bg-black px-4 py-2 text-xs font-medium text-white hover:bg-black"
          >Edit ✏️
          </a>
            <a href="delete_task.php?id=<?php echo $data['id'] ?>" class="inline-block rounded bg-black px-4 py-2 text-xs font-medium text-white hover:bg-black">Delete <span class="rotate-60" onclick="confirm('Are you sure you want to delete this task?')">❌</span></a>
        </td>
      </tr>
    </tbody>
<?php }?>
  </table>
        <?php
          }
        ?>
        </div>
</div>
<!-- user-edit -->
<div id="edit-profile" class="pt-8 hidden">
  <div class="user-edit__inner">
    <div class="user-edit__header">
      <h2 class="text-3xl mb-2">Edit User</h2>
    </div>
        <div>
    <div class="user-edit__body">
      <form method="POST" action="tasks.php" class="space-y-4">
            <!-- center user profile -->
            <label for="">Profile</label>
          <div class="flex items-center justify-center relative">
              <!-- if does not have an image -->
              <?php 
                if(!$userdata['profile']){
                  ?>
                  <img class="w-28 h-28 rounded-full" src="assets/img/default.svg" alt="user photo">
                  <?php
                }else{
              ?>
              <img class="w-28 h-28 rounded-full" src="assets/img/profile/<?php echo $userdata['profile'] ?>" alt="user photo">
              <?php }?>
              <svg class="absolute bottom-0 left-3/4 w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M3 16.8V9.2C3 8.0799 3 7.51984 3.21799 7.09202C3.40973 6.71569 3.71569 6.40973 4.09202 6.21799C4.51984 6 5.0799 6 6.2 6H7.25464C7.37758 6 7.43905 6 7.49576 5.9935C7.79166 5.95961 8.05705 5.79559 8.21969 5.54609C8.25086 5.49827 8.27836 5.44328 8.33333 5.33333C8.44329 5.11342 8.49827 5.00346 8.56062 4.90782C8.8859 4.40882 9.41668 4.08078 10.0085 4.01299C10.1219 4 10.2448 4 10.4907 4H13.5093C13.7552 4 13.8781 4 13.9915 4.01299C14.5833 4.08078 15.1141 4.40882 15.4394 4.90782C15.5017 5.00345 15.5567 5.11345 15.6667 5.33333C15.7216 5.44329 15.7491 5.49827 15.7803 5.54609C15.943 5.79559 16.2083 5.95961 16.5042 5.9935C16.561 6 16.6224 6 16.7454 6H17.8C18.9201 6 19.4802 6 19.908 6.21799C20.2843 6.40973 20.5903 6.71569 20.782 7.09202C21 7.51984 21 8.0799 21 9.2V16.8C21 17.9201 21 18.4802 20.782 18.908C20.5903 19.2843 20.2843 19.5903 19.908 19.782C19.4802 20 18.9201 20 17.8 20H6.2C5.0799 20 4.51984 20 4.09202 19.782C3.71569 19.5903 3.40973 19.2843 3.21799 18.908C3 18.4802 3 17.9201 3 16.8Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
          </div>

        <div>
          <label class="mb-2" for="name">Name</label>
          <input
            class="w-full rounded-lg border border-gray-200 p-3 text-sm"
            placeholder="Name"
            type="text"
            id="name"
            name="name"
            value="<?php echo $userdata['name'] ?>"
          />
        </div>
        <div>
          <label class="mb-2" for="email">Email</label>
          <input
            class="w-full rounded-lg border border-gray-200 p-3 text-sm"
            placeholder="Email"
            type="email"
            id="email"
            name="email"
            value="<?php echo $userdata['email'] ?>"
          />
        </div>
        <div class="mt-4 bg-black inline-block rounded-lg">
          <input
            type="submit"
            value="Update"
            class="w-full px-5 py-3 font-medium text-white sm:w-auto cursor-pointer"
            name="update_user"
          />
        </div>
        <div>
          <input type="hidden" name="action" value="update_profile">
        </div>
      </form>
    </div>
  </div>
</div>

</div>

<?php
              }
            ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"  type="text/javascript"></script>
<script>
function toggleSelectAll() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const selectAllCheckbox = document.getElementById('SelectAll');

  for (const checkbox of checkboxes) {
    checkbox.checked = selectAllCheckbox.checked;
  }
}
// toggle to all-task and edit-profile
const menuItems = document.querySelectorAll('.menu-item');
const taskWrapper = document.getElementById('task-wrapper');
const editProfile = document.getElementById('edit-profile');
menuItems.forEach((item) => {
  item.addEventListener('click', (e) => {
    e.preventDefault();
    const target = item.dataset.target;
    if (target === 'task-wrapper') {
      taskWrapper.classList.remove('hidden');
      editProfile.classList.add('hidden');
    } else {
      taskWrapper.classList.add('hidden');
      editProfile.classList.remove('hidden');
    }
  });
});


</script>
</body>
</html>