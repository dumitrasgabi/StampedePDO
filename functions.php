<?php

require_once 'connection.php';
require_once 'util_pentru_poo.php';

function is_logged_in() {
    if (!empty($_SESSION['SES']) && is_array($_SESSION['SES']) && !empty($_SESSION['SES']['id'])) {
        return true;
    }

    $cookie = $_COOKIE['SES'] ?? null;
    if ($cookie && strstr($cookie, ":")) {
        list($token_key, $token_value) = explode(":", $cookie);
        $result = query("SELECT * FROM users WHERE token_key = ? LIMIT 1", [$token_key]);

        if ($result) {
            $row = $result[0];
            if ($token_value === $row['token_value']) {
                $_SESSION['SES'] = $row;
                return true;
            }
        }
    }
    return false;
}

function is_admin_logged_in() {
    if (!empty($_SESSION['ADMIN_SES']) && is_array($_SESSION['ADMIN_SES']) && !empty($_SESSION['ADMIN_SES']['aid'])) {
        return true;
    }

    $cookie = $_COOKIE['ADMIN_SES'] ?? null;
    if ($cookie && strstr($cookie, ":")) {
        list($admin_token_key, $admin_token_value) = explode(":", $cookie);
        $result = query("SELECT * FROM admins WHERE admin_token_key = ? LIMIT 1", [$admin_token_key]);

        if ($result) {
            $row = $result[0];
            if ($admin_token_value === $row['admin_token_value']) {
                $_SESSION['ADMIN_SES'] = $row;
                return true;
            }
        }
    }
    return false;
}

function create_album($title, $artist, $genre) {
    $result = executeQuery("INSERT INTO albums (title, artist, genre) VALUES (?, ?, ?)", [$title, $artist, $genre]);

    if ($result) {
        return query("SELECT LAST_INSERT_ID() as id")[0]['id'];
    } else {
        echo "Failed to create album.<br>";
        return false;
    }
}

function create_review($albumId, $userId, $content, $rating) {
    global $con;

    $result = executeQuery("INSERT INTO reviews (album_id, user_id, content, rating, approved) VALUES (?, ?, ?, ?, 0)", 
                          [$albumId, $userId, $content, $rating]);

    if ($result) {
        executeQuery("UPDATE albums SET status = 'pending' WHERE id = ?", [$albumId]);
        return true;
    } else {
        echo "Failed to create review.<br>";
        return false;
    }
}

function get_pending_reviews() {
    return query("SELECT reviews.id, reviews.content, reviews.rating, albums.title AS album_title, users.user_name AS user_name 
                  FROM reviews 
                  JOIN albums ON reviews.album_id = albums.id 
                  JOIN users ON reviews.user_id = users.id 
                  WHERE reviews.approved = 0");
}

function reject_review($reviewId) {
    return executeQuery("DELETE FROM reviews WHERE id = ?", [$reviewId]);
}

function get_accepted_reviews($pdo, $search_query = '') {
    $query = "SELECT reviews.*, users.user_name AS user_name, albums.title AS album_title, albums.artist AS album_artist, albums.genre AS album_genre
              FROM reviews 
              JOIN users ON reviews.user_id = users.id 
              JOIN albums ON reviews.album_id = albums.id 
              WHERE reviews.approved = 1";

    $params = [];

    if (!empty($search_query)) {
        $query .= " AND (albums.title LIKE :search_query OR albums.artist LIKE :search_query)";
        $params = [':search_query' => "%$search_query%"];
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function query($query, $params = []) {
    global $con;
    $stmt = $con->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function executeQuery($query, $params = []) {
    global $con;
    $stmt = $con->prepare($query);
    return $stmt->execute($params);
}