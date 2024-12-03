<?php
$filepath = 'C:/xampp/htdocs/Web-Design-2024/Data/ThesisData/up0000002/211/notes.json';

// Check if the file exists
if (file_exists($filepath)) {
    echo "File exists.<br>";

    // Check file permissions
    if (is_readable($filepath)) {
        echo "File is readable.<br>";

        // Try to read the file contents
        $fileContents = file_get_contents($filepath);
        if ($fileContents === false) {
            echo "Failed to read the file.<br>";
        } else {
            echo "File contents: <br>" . $fileContents;
        }
    } else {
        echo "File is not readable.<br>";
    }
} else {
    echo "File does not exist.<br>";
}
?>
