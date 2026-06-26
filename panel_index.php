<?php
$msg = "";
$msg_type = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $file = $_FILES['file'];
    $filename = $file['name'];
    $filetype = $file['type'];
    $tmp = $file['tmp_name'];

    // Blacklist check (bypassable)
    $blacklist = array('php', 'php3', 'php4', 'phtml');
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // MIME check (bypassable)
    $allowed_mime = array('image/jpeg', 'image/png', 'image/gif');

    if(in_array($ext, $blacklist)){
        $msg = "Error: This file type is not allowed.";
        $msg_type = "error";
    } elseif(!in_array($filetype, $allowed_mime)){
        $msg = "Error: Only image files are allowed.";
        $msg_type = "error";
    } else {
        $upload_path = "../uploads/" . basename($filename);
        if(move_uploaded_file($tmp, $upload_path)){
            $msg = "File uploaded successfully: <a href='../uploads/" . basename($filename) . "'>View File</a>";
            $msg_type = "success";
        } else {
            $msg = "Upload failed.";
            $msg_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload — Uploader</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; color: #333; }
        header { background: #2c3e50; color: white; padding: 20px 40px; }
        header h1 { font-size: 28px; }
        header p { font-size: 14px; color: #aaa; }
        nav { background: #34495e; padding: 10px 40px; }
        nav a { color: #ecf0f1; text-decoration: none; margin-right: 20px; font-size: 14px; }
        nav a:hover { color: #3498db; }
        .container { max-width: 600px; margin: 60px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; margin-bottom: 10px; }
        p.sub { color: #888; font-size: 14px; margin-bottom: 25px; }
        input[type="file"] { width: 100%; padding: 10px; border: 2px dashed #ccc; border-radius: 6px; margin-bottom: 20px; cursor: pointer; }
        input[type="submit"] { background: #2c3e50; color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; }
        input[type="submit"]:hover { background: #3498db; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        footer { text-align: center; padding: 20px; background: #2c3e50; color: #aaa; font-size: 13px; margin-top: 40px; }
    </style>
</head>
<body>
    <header>
        <h1>📷 Uploader</h1>
        <p>A community photo blog — share your world</p>
    </header>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../about.php">About</a>
        <a href="index.php">Upload</a>
    </nav>
    <div class="container">
        <h2>Submit Your Photo</h2>
        <p class="sub">Share your moments with the community. Accepted formats: JPG, PNG, GIF.</p>

        <?php if($msg): ?>
            <div class="<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <input type="submit" value="Upload Photo">
        </form>
    </div>
    <footer>
        <p>© 2025 Uploader — All rights reserved</p>
    </footer>
</body>
</html>
