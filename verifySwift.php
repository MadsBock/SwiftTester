<?php

$filePath = $_POST["filename"];
$inputFile = $_POST["inputFile"];
$outputFile = $_POST["outputFile"];
$errorFile = "scripts/error.log";

$cmd = "swift $filePath < $inputFile 2> $errorFile";
if($output = shell_exec($cmd)) {
    $lines = explode("\n", $output);
    $outputLines = explode("\n", file_get_contents($outputFile));
    $header = "success";
    for($i = 0; $i < len($lines); $i++) {
        if($lines[$i] != $outputLines[$i]) {
            $output = "Expected '$outputLines[$i]' but got '$lines[$i]'";
            $header = "error";
            break;
        }
    }
    if($header == "success") {
        $output = "";
    }
} else {
    $output = implode("<br>", explode("\n", file_get_contents($errorFile)));
    $header = "error";
}

echo json_encode([$header,$output]);