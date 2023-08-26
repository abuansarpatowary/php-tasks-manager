<?php
include_once 'config.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
	$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$connection) {
		throw new Exception("Cannot connect to database");
	}
	$query = "SELECT * FROM " . DB_TABLE . " WHERE id = " . $id;
	$result = mysqli_query($connection, $query);
	$taskdata = mysqli_fetch_assoc($result);

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$taskname = $_POST['edit_taskname'];
		$taskdate = $_POST['edit_taskdate'];
		$tasktag = $_POST['edit_tasktags'];
		$query = "UPDATE " . DB_TABLE . " SET taskname = '$taskname', taskdate = '$taskdate', tasktags = '$tasktag' WHERE id = '$id'";
		$updated_result = mysqli_query($connection, $query);
		if($updated_result){
			header('location: index.php?updated=true');
			exit;
		}else{
			echo "Error: " . $query . "<br>" . mysqli_error($connection);
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tasks Manager with Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
</head>
<body>
<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <div class="overflow-x-auto">
        <h2 class="text-3xl py-8">Edit Task Manager</h2>
		<?Php
		if(mysqli_num_rows($result) ==0){
			?>
            <p>No Data Found</p>
			<?php
		}else{
		?>
<div class="mt-8">
	<h2>Edit Task</h2>
	<form method="POST" action="edit_task.php?id=<?php echo $_GET['id'] ?>" class="space-y-4">
		<div>
			<label class="sr-only" for="edit_taskname">Task Name</label>
			<input
				class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
				placeholder="Task Details"
				type="text"
				id="edit_taskname"
				name="edit_taskname"
				value="<?php echo $taskdata['taskname']; ?>"
			/>
		</div>
		<div>
			<label class="sr-only" for="edit_taskdate">Task Date</label>
			<input
				class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
				placeholder="Task Date"
				type="date"
				id="edit_taskdate"
				name="edit_taskdate"
				value="<?php echo $taskdata['taskdate']; ?>"
			/>
		</div>
		<div class="mt-4">
			<label class="sr-only" for="edit_tasktags">Task Tags</label>
			<input
				class="w-full rounded-lg border-2 border-gray-200 p-3 text-sm"
				placeholder="Task Tags"
				type="text"
				id="edit_tasktags"
				name="edit_tasktags"
				value="<?php echo $taskdata['tasktags']; ?>"
			/>
		</div>
		<div class="mt-4">
			<input
				type="hidden"
				name="action"
				value="edit"
			/>
			<input
				type="submit"
				value="Update Task"
				class="inline-block w-full rounded-lg bg-black px-5 py-3 font-medium text-white sm:w-auto"
			/>
		</div>
	</form>
</div>
<?php
        }
?>
    </div>
</div>
</body>
</html>

