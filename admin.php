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

// Fonksiyonlarımızı ekleyelim
function readHtmlFile($filename) {
    $content = "";
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
    }
    return $content;
}

function updateHtmlFile($filename, $content) {
    if (file_exists($filename)) {
        file_put_contents($filename, $content);
        return true;
    }
    return false;
}

// Dosya güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateFile'])) {
    $filename = $_POST['filename'];
    $content = $_POST['content'];

    if (updateHtmlFile($filename, $content)) {
        header('Location: admin.php');
        exit;
    } else {
        echo "Dosya güncellenemedi.";
    }
}

// Tüm dosyaların listesini oluşturalım
$htmlFiles = [
    'erlik.php' => 'Erlik',
    'kayra.php' => 'Kayra',
    'kizagan.php' => 'Kizagan',
    'mergen.php' => 'Mergen',
    'ulgen.php' => 'Ulgen',
    'umay.php' => 'Umay'
];

// Seçilen dosyanın içeriğini oku
$selectedFile = isset($_GET['file']) ? $_GET['file'] : '';
$fileContent = $selectedFile ? readHtmlFile($selectedFile) : '';

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
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .content {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        .home-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #333;
            text-decoration: none;
        }

        .home-link:hover {
            text-decoration: underline;
        }

        .logout {
            text-align: center;
            margin-bottom: 20px;
        }

        .logout a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout a:hover {
            background-color: #d32f2f;
        }

    </style>
</head>

<body>
<div class="container">
    <h2>Admin Panel - HTML Dosyaları İçerik Düzenleme</h2>
    <div class="logout"><a href="logout.php">Logout</a></div>

    <form method="get" action="">
        <label for="file">Düzenlenecek Dosyayı Seçin:</label>
        <select name="file" id="file" onchange="this.form.submit()">
            <option value="">Dosya Seçin</option>
            <?php foreach ($htmlFiles as $file => $name): ?>
                <option value="<?php echo $file; ?>" <?php echo ($selectedFile == $file) ? 'selected' : ''; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($selectedFile && $fileContent): ?>
        <form method="post" action="">
            <input type="hidden" name="filename" value="<?php echo $selectedFile; ?>">
            <textarea name="content" rows="10"><?php echo htmlspecialchars($fileContent); ?></textarea><br>
            <button type="submit" name="updateFile">Dosyayı Güncelle</button>
        </form>
        <div class="content">
            <h3>Dosya İçeriği Önizleme:</h3>
            <?php echo $fileContent; ?>
        </div>
    <?php endif; ?>

    <a class="home-link" href="index.php">Anasayfa</a>
</div>
</body>

</html>
