<?php
include "db_conn.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php?msg=Invalid record ID");
    exit();
}

$id = intval($_GET["id"]);

// Fetch menus for dropdown
$menus_query = "SELECT `ID`, `Name` FROM `restaurant menus` WHERE DateDeleted IS NULL";
$menus_result = mysqli_query($conn, $menus_query);

// Fetch products for dropdown
$products_query = "SELECT `ID`, `Name` FROM `restaurant products` ORDER BY `Name`";
$products_result = mysqli_query($conn, $products_query);

// Fetch current menuproduct record
$sql = "SELECT * FROM `restaurant menuproducts` WHERE ID = $id LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: index.php?msg=Record not found");
    exit();
}

if (isset($_POST["submit"])) {
    $menu_id = $_POST['MenuID'];
    $product_id = $_POST['ProductID'];

    $sql = "UPDATE `restaurant menuproducts` SET `MenuID` = '$menu_id', `ProductID` = '$product_id' WHERE ID = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: index.php?msg=Data updated successfully");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Potato Corner Menu List</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    Potato Corner Menu List
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit Menu Product</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Menu:</label>
            <select class="form-control" name="MenuID" required>
              <option value="">Select a menu...</option>
              <?php
              if (mysqli_num_rows($menus_result) > 0) {
                  while ($menuRow = mysqli_fetch_assoc($menus_result)) {
                      $selected = ($menuRow['ID'] == $row['MenuID']) ? 'selected' : '';
                      echo "<option value='" . $menuRow['ID'] . "' $selected>" . $menuRow['Name'] . " (ID: " . $menuRow['ID'] . ")</option>";
                  }
              } else {
                  echo "<option value=''>No menus available</option>";
              }
              ?>
            </select>
          </div>

          <div class="col">
            <label class="form-label">Product:</label>
            <select class="form-control" name="ProductID" required>
              <option value="">Select a product...</option>
              <?php
              if (mysqli_num_rows($products_result) > 0) {
                  while ($productRow = mysqli_fetch_assoc($products_result)) {
                      $selected = ($productRow['ID'] == $row['ProductID']) ? 'selected' : '';
                      echo "<option value='" . $productRow['ID'] . "' $selected>" . $productRow['Name'] . " (ID: " . $productRow['ID'] . ")</option>";
                  }
              } else {
                  echo "<option value=''>No products available</option>";
              }
              ?>
            </select>
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

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>