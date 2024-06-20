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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        input[type="text"], textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-self: center;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .home-button {
            background-color: #2196F3;
            margin-top: 20px;
        }

        .home-button:hover {
            background-color: #1976D2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .action-buttons form {
            display: inline;
        }

        .action-buttons a {
            color: #d9534f;
            text-decoration: none;
            margin-left: 10px;
        }

        .action-buttons a:hover {
            text-decoration: underline;
        }

        .logout {
            align-self: flex-end;
            margin-bottom: 20px;
        }

        .logout a {
            text-decoration: none;
            color: #d9534f;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Panel</h2>
    <div class="logout"><a href="logout.php">Logout</a></div>
    <h3>Add New Content</h3>
    <form method="post" action="">
        Title: <input type="text" name="title" required><br>
        Body: <textarea name="body" required></textarea><br>
        <button type="submit" name="add">Add</button>
    </form>
    <h3>All Content</h3>
    <table>
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
                        <td class='action-buttons'>
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
    <button class="home-button" onclick="window.location.href='index.php'">Anasayfa</button>
</div>
</body>
</html>
