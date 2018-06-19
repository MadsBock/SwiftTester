<?php
if(isset($_POST)) {
    include 'mysql.php';
    $txt = $_POST["text"];
    $assSQL = "INSERT INTO assignments (text) VALUES ('$txt');";
    if($conn->query($assSQL)) {
        $id = $conn->insert_id;
        $timestamp = time();
        $inputPath = "scripts/input/$timestamp";
        $outputPath = "scripts/output/$timestamp";
        file_put_contents($inputPath, $_POST["input"]);
        file_put_contents($outputPath, $_POST["output"]);
        $veriSQL = "INSERT INTO verificationPair (inputFilePath, outputFilePath, assignmentID) VALUES ('$inputPath', '$outputPath', '$id');";
        if($conn->query($veriSQL)) {
            echo "<span style='color: green'>Success</span>";
        } else {
            die(var_dump([$veriSQL,$conn->error]));
        }
    } else {dir($conn->error);}

}
?>

<form action="" method="post">
    <input type="text" name="text">
    <input type="text" name="input">
    <input type="text" name="output">
    <input type="submit" value="submit">
</form>