<?php
//var_dump($_FILES["file"]);
$tmp = $_FILES["file"]["tmp_name"];
$id = $_POST["id"];
$datetime = time();
$newPos = "scripts/uploads/$datetime".".swift";
move_uploaded_file($tmp, $newPos);
?>
<style>
    .butTemp {
        display: none;
    }
</style>
<button class="butTemp but">Kør Test</button>

<script src="jquery.js"></script>

<script>
    function makeButton(inputF, outputF) {

        $(".butTemp").clone().removeClass("butTemp").appendTo("body").click(function() {
            console.log("Works")
            var params = {
                filename: "<?= $newPos ?>",
                inputFile: inputF,
                outputFile: outputF
            }
            var target = $(this)
            $.post("verifySwift.php", params, function(data, status) {
                var color = "red"
                if(data[0] == "success") {
                    color = "lightgreen"
                }
                target.html(data[1]).css("color", color)
            }, "json")
        })
    }

<?php
include "mysql.php";
$sql = "SELECT inputFilePath AS inp, outputFilePath AS oup FROM verificationPair WHERE assignmentID = $id";
if($result = $conn->query($sql)) {
    while($row = $result->fetch_assoc()) {
        $inputFile = $row["inp"];
        $outputFile = $row["oup"];
        echo "makeButton('$inputFile', '$outputFile');";
    }
} else {
    echo $conn->error . "\n";
    echo $sql;
}
?>
</script>