<?php
session_start();
include('config.php');

// Oturum süresi kontrolü
if (!isset($_SESSION['loggedin']) || (time() - $_SESSION['timeout'] > 300)) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
} else {
    $_SESSION['timeout'] = time();
}

// İçerikleri getir
$sql = "SELECT * FROM content";
$result = $conn->query($sql);

// İçerik ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];

    $sql = "INSERT INTO content (title, body) VALUES ('$title', '$body')";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// İçerik güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    $sql = "UPDATE content SET title='$title', body='$body' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// İçerik silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM content WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
<h2>Admin Panel</h2>
<a href="logout.php">Logout</a>
<h3>Add New Content</h3>
<form method="post" action="">
    Title: <input type="text" name="title" required><br>
    Body: <textarea name="body" required></textarea><br>
    <button type="submit" name="add">Add</button>
</form>
<h3>All Content</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Body</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td><input type='text' name='title' value='" . $row["title"] . "'></td>
                    <td><textarea name='body'>" . $row["body"] . "</textarea></td>
                    <td>" . $row["created_at"] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='hidden' name='title' value='" . $row["title"] . "'>
                            <input type='hidden' name='body' value='" . $row["body"] . "'>
                            <button type='submit' name='update'>Update</button>
                        </form>
                        <a href='admin.php?delete=" . $row["id"] . "'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No content found</td></tr>";
    }
    ?>
</table>
</body>
</html>
