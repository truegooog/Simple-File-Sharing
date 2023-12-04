<?php
$uploadDirectory = 'files/';

if ($_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
    $fileName = $_FILES['fileUpload']['name'];
    $fileTmp = $_FILES['fileUpload']['tmp_name'];
    $fileSize = $_FILES['fileUpload']['size'];
    $fileType = $_FILES['fileUpload']['type'];

    // Allowed file extensions
    $allowedExtensions = array("torrent", "zip", "rar", "html", "txt", "jpg", "jpeg", "png", "gif", "mp3", "mp4", "pdf");

    // Get file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file extension is allowed
    if (in_array($fileExtension, $allowedExtensions)) {
        // Check file size (max 10MB)
        if ($fileSize <= 10 * 1024 * 1024) {
            // Create a random folder name
            $randomFolder = uniqid();
            $folderPath = $uploadDirectory . $randomFolder . '/';

            // Create directory if it doesn't exist
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // Move uploaded file to the random folder
            $newFilePath = $folderPath . $fileName;
            move_uploaded_file($fileTmp, $newFilePath);

            // Display direct link to the uploaded file
            $fileLink = $_SERVER['HTTP_HOST'] . '/' . $newFilePath;

            echo "File uploaded successfully.";
            echo "<br/><a href='http://$fileLink'>$fileLink</a>";
        } else {
            echo "File size exceeds the limit (Max 10MB)";
        }
    } else {
        echo "File type not supported";
    }
} else {
    echo "Error uploading file";
}
?>
