<?php

require_once 'app/init.php';

if(isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $category = $_POST['category'];

    if(!empty($name)) {
        $addedQuery = $db->prepare("
            INSERT INTO items (name, user, done, created, categoryID)
            VALUES (:name, :user, 0, NOW(), :categoryID)
        ");

        $addedQuery->execute([
            'name' => $name,
            'categoryID' => $category,
            'user' => $_SESSION['user_id']
        ]);
    }
}
header('Location: index.php');