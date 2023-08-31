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
    $query = "SELECT * FROM " . DB_TABLE;
    $result = mysqli_query($connection, $query);
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
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="https://flowbite.com" class="flex ml-2 md:mr-24">
          <svg id="logo-9" width="152" height="19" viewBox="0 0 152 19" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M75.693 16.374H70.573V2.686H75.693V16.374ZM71.073 15.874H75.193V3.186H71.073V15.874ZM82.817 16.374H77.8V2.686H88.282C89.7836 2.5644 91.279 2.98597 92.496 3.874C93.0199 4.35331 93.426 4.94719 93.6825 5.60929C93.9391 6.2714 94.0392 6.98383 93.975 7.691C94.0498 8.91297 93.6609 10.1182 92.886 11.066C91.969 12.118 90.443 12.66 88.351 12.679C87.824 12.693 83.875 12.679 82.82 12.679L82.817 16.374ZM78.297 15.874H82.317V12.174H82.568C82.619 12.174 87.746 12.19 88.339 12.174C90.288 12.157 91.689 11.674 92.508 10.731C93.1978 9.87345 93.5404 8.78815 93.468 7.69C93.5295 7.05637 93.4442 6.41709 93.2188 5.82174C92.9933 5.22639 92.6338 4.69097 92.168 4.257C91.0396 3.4471 89.659 3.06693 88.275 3.185H78.3L78.297 15.874ZM87.22 9.604H82.283V5.878H87.253C87.6053 5.82932 87.9642 5.87044 88.2963 5.99753C88.6285 6.12463 88.9232 6.33358 89.153 6.605C89.3615 6.95194 89.4598 7.35398 89.435 7.758C89.4537 8.1331 89.3727 8.50647 89.2 8.84C88.9629 9.12588 88.6562 9.34595 88.3094 9.47905C87.9627 9.61215 87.5875 9.6538 87.22 9.6V9.604ZM82.783 9.104H87.22C88.04 9.104 88.548 8.933 88.773 8.581C88.8969 8.32515 88.953 8.04176 88.936 7.758C88.9579 7.46006 88.8933 7.16214 88.75 6.9L88.744 6.891C88.506 6.541 88.033 6.378 87.253 6.378H82.783V9.104ZM103.1 16.576C98.61 16.576 95.93 15.461 94.909 13.168C94.7419 12.7251 94.6285 12.2638 94.571 11.794L94.527 11.506H99.869L99.904 11.716C99.9451 11.9292 100.036 12.1299 100.168 12.302C100.379 12.557 101.083 12.985 103.419 12.985C106.227 12.985 106.227 12.492 106.227 12.227C106.227 11.78 105.902 11.627 103.612 11.383L103.177 11.342C102.315 11.261 101.225 11.158 100.727 11.115C96.527 10.735 94.652 9.43 94.652 6.885C94.652 4.212 97.843 2.485 102.782 2.485C106.811 2.485 109.407 3.547 110.496 5.644C110.754 6.13178 110.928 6.65999 111.009 7.206L111.044 7.487H105.696L105.674 7.261C105.653 7.08438 105.578 6.91869 105.458 6.787C105.258 6.519 104.626 6.076 102.664 6.076C100.255 6.076 99.923 6.384 99.923 6.716C99.923 7.159 100.684 7.316 103.123 7.577C104.14 7.66 105.775 7.828 106.335 7.896C109.856 8.278 111.427 9.551 111.427 12.025C111.428 14.1 109.983 16.576 103.1 16.576ZM95.111 12.006C95.1611 12.3358 95.2473 12.659 95.368 12.97C96.298 15.059 98.828 16.076 103.1 16.076C106.672 16.076 110.931 15.376 110.931 12.025C110.931 9.832 109.541 8.746 106.282 8.393C105.722 8.325 104.097 8.158 103.082 8.074C100.482 7.792 99.425 7.642 99.425 6.716C99.425 5.758 100.564 5.576 102.666 5.576C104.327 5.576 105.4 5.876 105.855 6.481C105.979 6.63005 106.073 6.80195 106.131 6.987H110.465C110.378 6.60025 110.24 6.22669 110.055 5.876C109.055 3.957 106.612 2.985 102.784 2.985C98.149 2.985 95.154 4.516 95.154 6.885C95.154 9.145 96.835 10.261 100.773 10.617C101.273 10.66 102.362 10.763 103.226 10.845L103.664 10.886C105.791 11.11 106.729 11.25 106.729 12.227C106.729 13.279 105.516 13.485 103.421 13.485C101.483 13.485 100.259 13.194 99.786 12.621C99.6402 12.4383 99.5302 12.2296 99.462 12.006H95.111ZM120.927 16.559C115.707 16.559 112.827 14.448 112.827 10.614V2.686H117.879V10.614C117.879 11.929 119.056 12.683 121.107 12.683C123.067 12.683 124.284 11.896 124.284 10.631V2.686H129.284V11.034C129.289 14.545 126.24 16.559 120.924 16.559H120.927ZM113.327 3.186V10.614C113.327 15.352 118.085 16.059 120.927 16.059C123.865 16.059 128.792 15.406 128.792 11.034V3.186H124.792V10.631C124.792 12.181 123.348 13.183 121.115 13.183C118.781 13.183 117.387 12.223 117.387 10.614V3.186H113.327ZM150.472 16.374H145.704V10.194L143 16.374H138.841L136.165 10.206V16.374H131.38V2.686H137.674L140.944 10.233L144.372 2.686H150.478L150.472 16.374ZM146.204 15.874H149.972V3.186H144.69L140.928 11.465L137.342 3.186H131.876V15.874H135.661V7.8L139.161 15.877H142.661L146.198 7.812L146.204 15.874ZM6.054 2.936H1.5V16.124H14.084V12.613H6.054V2.936ZM23.276 2.636C17.463 2.636 14.406 5.391 14.406 9.436C14.406 14.006 17.615 16.324 23.276 16.324C29.508 16.324 32.129 13.636 32.129 9.436C32.129 5.171 29.172 2.634 23.276 2.634V2.636ZM23.259 6.063C23.6547 6.06114 24.0502 6.08418 24.443 6.132L19.352 11.223C19.1111 10.6781 18.9936 10.0866 19.008 9.491C19.008 7.422 20.05 6.061 23.259 6.061V6.063ZM23.276 12.951C22.8947 12.9527 22.5137 12.9313 22.135 12.887L27.235 7.787C27.4669 8.3229 27.5779 8.90333 27.56 9.487C27.56 11.5 26.6 12.949 23.276 12.949V12.951ZM41.152 11.151H45.839C45.77 11.4763 45.6262 11.781 45.419 12.041C44.4473 12.8326 43.2072 13.2178 41.958 13.116C41.3292 13.1833 40.6934 13.1146 40.0935 12.9146C39.4936 12.7147 38.9436 12.3881 38.481 11.957C38.0071 11.2619 37.782 10.4271 37.842 9.588C37.7653 8.70874 38.0101 7.83152 38.531 7.119C39.186 6.379 40.295 6.06 41.925 6.06C42.9621 5.97413 43.9979 6.24048 44.865 6.816C45.1383 7.03308 45.3426 7.32491 45.453 7.656H49.8C49.7684 7.11047 49.6372 6.57533 49.413 6.077C48.372 3.96 45.952 2.7 41.837 2.7C38.258 2.7 35.856 3.792 34.529 5.439C33.6526 6.62836 33.2027 8.07844 33.252 9.555C33.1953 11.065 33.6336 12.5521 34.5 13.79C35.811 15.49 38.146 16.326 40.952 16.326C42.8175 16.4561 44.6703 15.9336 46.193 14.848L46.311 16.124H49.922V8.312H41.152V11.151ZM60.171 2.633C54.359 2.633 51.301 5.388 51.301 9.433C51.301 14.003 54.509 16.321 60.171 16.321C66.404 16.321 69.025 13.633 69.025 9.433C69.025 5.171 66.068 2.634 60.171 2.634V2.633ZM60.155 6.06C60.5403 6.05886 60.9253 6.0809 61.308 6.126L56.237 11.2C56.0036 10.6611 55.89 10.0781 55.904 9.491C55.9 7.422 56.946 6.061 60.155 6.061V6.06ZM60.171 12.948C59.7796 12.9497 59.3885 12.9269 59 12.88L64.117 7.762C64.3577 8.30503 64.4729 8.89532 64.454 9.489C64.456 11.5 63.5 12.949 60.171 12.949V12.948Z" class="ccustom" fill="#394149"></path> </svg>
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ml-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
              </button>
            </div>
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                  John Doe
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                  john.doe@gmail.com
                </p>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
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
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Dask</title><path d="m11.246 9.754 5.848-3.374a.202.202 0 0 0 .1-.175l.002-2.553c0-.324-.133-.645-.392-.841a1 1 0 0 0-1.118-.074l-2.425 1.4-6.436 3.712a1.007 1.007 0 0 0-.504.872l-.003 8.721v2.825c0 .324.132.645.39.842.335.253.766.278 1.12.074l2.363-1.364a.202.202 0 0 0 .101-.175l.003-8.244a1.902 1.902 0 0 1 .951-1.646Zm10.316-4.336a1.005 1.005 0 0 0-.504-.137.997.997 0 0 0-.503.137l-8.86 5.112a1.01 1.01 0 0 0-.505.87l-.003 11.591c0 .364.188.69.503.872a.995.995 0 0 0 1.007 0l8.86-5.112a1.01 1.01 0 0 0 .504-.872l.004-11.59a.997.997 0 0 0-.503-.871ZM6.378 7.074l6.334-3.655a.202.202 0 0 0 .1-.175l.001-2.193c0-.324-.133-.646-.392-.84a1 1 0 0 0-1.118-.075L2.443 5.25a1.007 1.007 0 0 0-.504.872l-.003 11.546c0 .324.133.645.39.842a1 1 0 0 0 1.12.074l1.877-1.082a.202.202 0 0 0 .1-.175l.003-8.605c0-.68.363-1.307.952-1.647z"/></svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Tasks</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
               </svg>
               <span class="flex-1 ml-3 whitespace-nowrap">Sign In</span>
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
<div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
<div class="overflow-x-auto">
  <h2 class="text-3xl py-8">Task Manager</h2>
  <?Php 
    if(mysqli_num_rows($result) == 0){
      ?>
      <p>No Data Found</p>
      <?php
    }else{
  ?>
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

    <tbody class="divide-y divide-gray-200">
      <?php 
        while($data = mysqli_fetch_assoc($result)){
      ?>
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
<?php }?>
    </tbody>
  </table>
  <?php
    }
  ?>
  <!-- form -->
  <div class="pt-8">
    <h2>Add Task</h2>
  <form method="POST" action="tasks.php" class="space-y-4">
          <div>
            <label class="sr-only" for="taskname">Task Name</label>
            <input
              class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
              placeholder="Tasks Details"
              type="text"
              id="taskname"
              name="taskname"
            />
          </div>
          <div>
            <label class="sr-only" for="taskdate">Task Date</label>
            <input
              class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
              placeholder="Tasks Date"
              type="date"
              id="taskdate"
              name="taskdate"
            />
          </div>
          
          <div class="mt-4">
            <label class="sr-only" for="tasktags">Task Tags</label>
            <input
              class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
              placeholder="Tasks Tags"
              type="text"
              id="tasktags"
              name="tasktags"
            />
          </div>
          <div class="mt-4">
            <input
              type="submit"
              value="Add Task"
              class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto"
            />
          </div>
          <div>
            <input type="hidden" name="action" value="add">
          </div>
  </form>
</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"  type="text/javascript"></script>
<script>
function toggleSelectAll() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const selectAllCheckbox = document.getElementById('SelectAll');

  for (const checkbox of checkboxes) {
    checkbox.checked = selectAllCheckbox.checked;
  }
}
</script>
</body>
</html>