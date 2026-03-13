<?php
$file = '../databases/database_shr.txt';
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = [];
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) >= 5) {
                $data[] = [
                    'week_num' => $parts[0], 'lesson_num' => $parts[1],
                    'day_index' => $parts[2], 'subject' => $parts[3], 'cabinet' => $parts[4]
                ];
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $input) {
    $target = implode('|', array_map('trim', $input)); 
    
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $filtered = array_filter($lines, function($line) use ($target) {
            return trim($line) !== $target; 
        });
        file_put_contents($file, implode("\n", $filtered) . (empty($filtered) ? "" : "\n"));
        echo json_encode(["status" => "Deleted"]);
    }
    exit;
}

if ($input) {
    $new_line = implode('|', array_map('trim', $input)) . "\n";
    file_put_contents($file, $new_line, FILE_APPEND); 
    echo json_encode(["status" => "Success"]);
    exit;
}
?>