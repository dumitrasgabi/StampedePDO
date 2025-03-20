<?php
    require_once 'functions.php';
    $sql1="DROP TRIGGER IF EXISTS BeforeDeleteTrigger";
    $sql2="CREATE TRIGGER BeforeDeleteTrigger BEFORE DELETE ON trending_reviews FOR EACH ROW
    BEGIN
    INSERT INTO trending_update(old_artist, new_artist, old_title, new_title, status, edtime) VALUES (OLD.artist, OLD.artist, OLD.title, OLD.title, 'DELETED', NOW());
    END;";

    $stmt1=$con->prepare($sql1);
    $stmt2=$con->prepare($sql2);
    $stmt1->execute();
    $stmt2->execute();
?>