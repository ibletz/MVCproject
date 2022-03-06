<?php

require_once 'app/init.php';

$itemsQuery = $db->prepare("
    SELECT id, name, done, categoryID
    FROM items
    WHERE user = :user
");

$itemsQuery->execute ([
    'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];

$categoryQuery = $db->prepare("
    SELECT categoryName
    FROM categories
    WHERE categoryID = :categoryID
");




$categories = $categoryQuery->rowCount() ? $categoryQuery : [];

/*
foreach($items as $item) {
    print_r($item);
}
*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To do App</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two" rel="stylesheet"> 
        <link rel="stylesheet" href="css/main.css">

        <meta name="viewport" conten="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="list">
            <h1 class="header">To do.</h1>
            
            <?php if(!empty($items)): ?>
            <ul class="items">
                <?php foreach($items as $item): ?>
                    <li>
                        <span class="item<?php echo $item['done'] ? ' done' : ''?>"><?php echo $item['name'] ?></span>
                        <?php if(!$item['done']): ?>
                            <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Done</a>
                        <?php else: ?>
                            <a href="mark.php?as=notdone&item=<?php echo $item['id']; ?>" class="undo-button">Undo</a>
                        <?php endif; ?>
                        <label class="category-label"><?php echo $item['categoryID']; ?></label>


                        <a href="mark.php?as=delete&item=<?php echo $item['id']; ?>" class="delete-button">x</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <p>You haven't added any items yet.</p>
            <?php endif; ?>

            <span>
                <form class="item-add" action="add.php" method="post">
                    <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
                    <span>
                        <Label class="category-select">Category:</Label>
                        <select name="category">
                            <option value="1">Errands</option>
                            <option value="2">Chores</option>
                            <option value="3">School</option>
                            <option value="4">Social</option>
                            <option value="5">Family</option>
                            <option value="6">Work</option>     
                            <option value="7">Appointments</option>     
                            <option value="8">Other</option>
                        </span>
                    <input type="submit" value="Add" class="submit">
                </form>
            </span>
        </div>
    </body>
</html>