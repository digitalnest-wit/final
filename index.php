<?php
// Initiates the PHP session, allowing us to store data across different page
// loads. Here, it enables us to keep the task list in $_SESSION as users
// interact with the page.
session_start();

// Initialize tasks array if not already set in session.
if (!isset($_SESSION['tasks'])) {
  $_SESSION['tasks'] = [];
}

// Add new task if form is submitted.
if (!empty($_POST['name'])) {
  // Append the task the array of tasks in the session.
  $_SESSION['tasks'][] = $_POST['name'];
  // Redirect to prevent re-submission.
  header("Location: " . $_SERVER['PHP_SELF']);
  // Ensures that the redirect happens by terminating the script.
  exit();
}

// Delete task if delete request is submitted.
if (isset($_POST['delete_id'])) {
  // Remove task by ID.
  $delete_id = $_POST['delete_id'];
  unset($_SESSION['tasks'][$delete_id]);
  // Re-index the tasks array.
  $_SESSION['tasks'] = array_values($_SESSION['tasks']);
  // Redirect to prevent re-submission.
  header("Location: " . $_SERVER['PHP_SELF']);
  // Ensures that the redirect happens by terminating the script.
  exit();
}

// Function to render each task
function render_new_task($task, $id)
{
  echo "<div class=\"task\" id=\"task-$id\">";
  echo "  <span>$task</span>";
  // The form contains a hidden label with the id of the task for deletion and
  // the delete button itself to remove a task from the list.
  echo "  <form method=\"post\" style=\"display:inline;\">";
  echo "    <input type=\"hidden\" name=\"delete_id\" value=\"$id\">";
  echo "    <button type=\"submit\" class=\"mx-2 btn btn-link text-warning p-0\">clear</button>";
  echo "  </form>";
  echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>To-do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="styles/stylesheet.css" />
</head>

<body>
  <header class="px-3 pt-3 pb-1 sticky-top bg-warning-subtle text-wite shadow-sm">
    <h1>Tasks</h1>
    <form class="container-fluid" method="post" id="form-new-task">
      <div class="row mt-3 mb-2">
        <input
          class="mb-2 py-2 bg-warning-light border-0 shadow-sm rounded col"
          type="text"
          name="name"
          placeholder="Create a new task" />
        <button
          class="mx-sm-2 mb-2 py-2 btn btn-dark text-white col-12 col-sm-3 col-md-2 col-lg-2 col-xl-1"
          type="submit">
          New Task
        </button>
      </div>
    </form>
  </header>
  <main class="m-2 p-1">
    <div class="task-list">
      <?php
      foreach ($_SESSION['tasks'] as $id => $task) {
        render_new_task($task, $id);
      }
      if (empty($_SESSION['tasks'])) {
        echo "<div id=\"no-tasks-view\" class=\"text-body-tertiary\">";
        echo "  There are no new tasks.";
        echo "</div>";
      }
      ?>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>