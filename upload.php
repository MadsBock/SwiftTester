<?php
//var_dump($_FILES["file"]);
$tmp = $_FILES["file"]["tmp_name"];
$id = $_POST["id"];
$datetime = time();
$newPos = "scripts/uploads/$datetime".".swift";
move_uploaded_file($tmp, $newPos);
?>

<p id="successBlock" style="background-color: lightgreen; display: none"></p>
<p id="errorBlock" style="background-color: red; display: none"></p>

<script src="jquery.js"></script>

<script>
    $(document).ready(function() {
        var params = {
            filename: "<?= $newPos ?>",
            id: <?= $id ?>
        }
        console.log(params)
        $.post("verifySwift.php", params, function(data, status) {
            console.log(data)
            console.log(data[0])
            if(data[0] == "success") {
                console.log("success")
                for (let i = 1; i < data.length; i++) {
                    const element = data[i];
                    $("#successBlock").clone().appendTo("body").html(element).fadeIn()
                }

            } else {
                console.log("Error")
                for(let i = 1; i < data.length; i++) {
                    const element = data[i]
                    $("#errorBlock").clone().appendTo("body").html(element).fadeIn()
                }
            }
        }, "json")
    })
</script>