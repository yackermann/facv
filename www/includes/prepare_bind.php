<?php
   	$stmt = $pdo->prepare($query);
    $stmt->bindParam(':activity', $_POST['activity'], PDO::PARAM_STR );
    $stmt->bindParam(':theme', $_POST['theme'], PDO::PARAM_STR );
    $stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR );
    $stmt->bindParam(':website', $_POST['website'], PDO::PARAM_STR );
    $stmt->bindParam(':image', $_POST['image'], PDO::PARAM_STR );
    $stmt->bindParam(':tourguide_id', $_POST['tourguide_id'], PDO::PARAM_STR );
?>