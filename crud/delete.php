<?php
include "db_conn.php";

if (!isset($_GET["id"]) || empty($_GET["id"]) || !isset($_GET["type"])) {
    header("Location: index.php?msg=Invalid request");
    exit();
}

$id = intval($_GET["id"]);
$type = $_GET["type"];

if ($type == "menu") {
    $sql = "UPDATE `restaurant menus` SET DateDeleted = NOW() WHERE ID = $id";
} elseif ($type == "product") {
    $sql = "DELETE FROM `restaurant products` WHERE ID = $id";
} elseif ($type == "menuproduct") {
    $sql = "DELETE FROM `restaurant menuproducts` WHERE ID = $id";
} else {
    header("Location: index.php?msg=Invalid type");
    exit();
}

$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: index.php?msg=Data deleted successfully");
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>