<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Tasks Manager with Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
</head>
<body>

<!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->
<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
<div class="overflow-x-auto">
  <h2 class="text-3xl py-8">Task Manager</h2>
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
        Analyse the macro-location
        </td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">24/05/1995</td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">Web Developer</td>
        <td class="whitespace-nowrap px-4 py-2">
          <a
            href="#"
            class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700"
          >
            Edit
          </a>
        </td>
      </tr>

      <tr>
        <td class="sticky inset-y-0 start-0 bg-white px-4 py-2">
          <label class="sr-only" for="Row2">Row 2</label>

          <input
            class="h-5 w-5 rounded border-gray-300"
            type="checkbox"
            id="Row2"
          />
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
        Check if the correct SAM is assigned to the project
        </td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">04/11/1980</td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">Web Designer</td>
        <td class="whitespace-nowrap px-4 py-2">
          <a
            href="#"
            class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700"
          >
            Edit
          </a>
        </td>
      </tr>

      <tr>
        <td class="sticky inset-y-0 start-0 bg-white px-4 py-2">
          <label class="sr-only" for="Row3">Row 3</label>

          <input
            class="h-5 w-5 rounded border-gray-300"
            type="checkbox"
            id="Row3"
          />
        </td>
        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
          Gary Barlow
        </td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">24/05/1995</td>
        <td class="whitespace-nowrap px-4 py-2 text-gray-700">Singer</td>
        <td class="whitespace-nowrap px-4 py-2">
          <a
            href="#"
            class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700"
          >
            Edit
          </a>
        </td>
      </tr>
    </tbody>
  </table>
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
            />
          </div>
          <div>
            <label class="sr-only" for="taskdate">Task Date</label>
            <input
              class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
              placeholder="Tasks Date"
              type="date"
              id="taskdate"
            />
          </div>
          <div class="mt-4">
            <label class="sr-only" for="tasktags">Task Tags</label>
            <input
              class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
              placeholder="Tasks Tags"
              type="text"
              id="tasktags"
            />
          </div>
          <div class="mt-4">
            <input
              type="submit"
              value="Add Task"
              class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto"
            />
          </div>
  </form>
</div>
</div>
</div>
<script>
function toggleSelectAll() {
  const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
  const selectAllCheckbox = document.getElementById('SelectAll');

  for (const checkbox of checkboxes) {
    checkbox.checked = selectAllCheckbox.checked;
  }
}
</script>
</body>
</html>