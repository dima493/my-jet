<?php
$file = '../databases/database.txt';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($file)) {
        echo file_get_contents($file);
    }
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    $line_to_find = $input['subject'] . "|" . $input['file'];   
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        $new_lines = array_filter($lines, function($line) use ($line_to_find) {
            return trim($line) !== $line_to_find;
        });
        file_put_contents($file, implode("\n", $new_lines) . "\n");
        echo "Deleted";
    } else {
        file_put_contents($file, $line_to_find . "\n", FILE_APPEND);
        echo "Success";
    }
}
?>