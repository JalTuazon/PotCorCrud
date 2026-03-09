<?php
include "db_conn.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php?msg=Invalid record ID");
    exit();
}

$id = intval($_GET["id"]);

if (isset($_POST["submit"])) {
  $name = $_POST['name'];

  $sql = "UPDATE `restaurant menus` SET `Name`='$name', `DateUpdated`= NOW() WHERE ID = $id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: index.php?msg=Data updated successfully");
  } else {
    echo "Failed: " . mysqli_error($conn);
  }
}

$sql = "SELECT * FROM `restaurant menus` WHERE ID = $id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: index.php?msg=Record not found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Potato Corner Menu List</title>
</head>
<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    Potato Corner Menu List
  </nav>
  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit Menu Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>
    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $row['Name'] ?>">
          </div>
        </div>
        <div class="mb-3">&nbsp;</div>
        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="index.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>