<?php

$filePath = $_POST["filename"];
$id = $_POST["id"];
$errorFile = "error.log";
include 'mysql.php';

$sql = "SELECT inputFilePath AS input FROM verificationPair WHERE assignmentID = $id;";
$result = $conn->query($sql) or die ("Query Failed");
$row = $result->fetch_assoc();
$inputPath = $row["input"];

$cmd = "swift $filePath < $inputPath 2>$errorFile";
if($output = shell_exec($cmd)) {
    $lines = explode("\n", $output);
    $header = "success";
} else {
    $lines = [implode("<br>", explode("\n", file_get_contents($errorFile)))];
    $header = "error";
}
$lines = array_merge([$header], $lines);
unlink($errorFile);
echo json_encode($lines);