<?php
require_once 'functions.php';

$sql1 = "DROP TRIGGER IF EXISTS BeforeInsertTrigger";
$sql2 = "CREATE TRIGGER BeforeInsertTrigger BEFORE INSERT ON trending_reviews FOR EACH ROW
BEGIN
    SET NEW.artist = UPPER(NEW.artist);
    SET NEW.title = LOWER(NEW.title);
END;";

$stmt1 = $con->prepare($sql1);
$stmt2 = $con->prepare($sql2);

$stmt1->execute();
$stmt2->execute();

$sql3 = "DROP TRIGGER IF EXISTS AfterInsertTrigger";
$sql4 = "CREATE TRIGGER AfterInsertTrigger AFTER INSERT ON trending_reviews FOR EACH ROW
BEGIN 
    INSERT INTO trending_update(old_artist, new_artist, old_title, new_title, status, edtime) VALUES (NEW.artist, new.ARTIST, NEW.title, NEW.title, 'INSERTED', NOW());
END;";

$stmt3 = $con->prepare($sql3);
$stmt4 = $con->prepare($sql4);

$stmt3->execute();
$stmt4->execute(); 
