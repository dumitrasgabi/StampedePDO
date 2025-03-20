<?php 
    require_once 'functions.php';
    $sql1 = "DROP TRIGGER IF EXISTS BeforeUpdateTrigger";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute();
    $sql2 = "CREATE TRIGGER BeforeUpdateTrigger BEFORE UPDATE ON trending_reviews FOR EACH ROW
    BEGIN
        SET NEW.author = LOWER(NEW.author);
        SET NEW.title = UPPER(NEW.title);
    END;";
    $stmt2 = $con->prepare($sql2);
    $stmt2->execute();

    $sql3 = "DROP TRIGGER IF EXISTS AfterUpdateTrigger";
    $stmt3 = $con->prepare($sql3);
    $stmt3->execute();

    $sql4 = "CREATE TRIGGER AfterUpdateTrigger AFTER UPDATE ON trending_reviews FOR EACH ROW
    BEGIN
        INSERT INTO trending_update(old_artist, new_artist, old_title, new_title, status, edtime) VALUES (OLD.artist, NEW.artist, OLD.title, NEW.title, 'UPDATED', NOW());
    END;";
    $stmt4 = $con->prepare($sql4);
    $stmt4->execute();
?>
