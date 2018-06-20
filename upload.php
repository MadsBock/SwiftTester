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
    #details {
        padding: 5px;
        margin-top: 10px;
    }
</style>
<div class="butTemp">
    <button class="but">Kør Test</button>
    <div id="details" style="display: none"></div>
</div>

<script src="jquery.js"></script>

<script>
    function makeButton(inputF, outputF) {

        $(".butTemp").clone().removeClass("butTemp").appendTo("body").find("button").click(function() {
            console.log("Works")
            var params = {
                filename: "<?= $newPos ?>",
                inputFile: inputF,
                outputFile: outputF
            }
            var details = $(this).siblings("#details").slideUp()
            $.post("verifySwift.php", params, function(data, status) {
                var color = "red"
                console.log(data)
                if(data[0] == "success") {
                    color = "lightgreen"
                }
                console.log(details)
                details.html(data[1]).css("background-color", color).slideDown()
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