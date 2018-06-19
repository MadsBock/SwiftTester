<style>
    .list {
        background-color: lightblue;
        width: 400px;
        margin-bottom:40px;
        padding-bottom:20px;
        padding-top:5px;
    }

    .list a {
        background-color: yellow;
        float: right;
        cursor:hand;
        text-decoration:none;
        
    }
</style>

<?php
include 'mysql.php';
$sql = "SELECT id,text FROM assignments LIMIT 20";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
?>

<div class="list">
    <?= $row["text"] ?>
    <a href="editAssignment.php?id=<?= $row["id"]?>">edit</a>
</div>


<?php
}
