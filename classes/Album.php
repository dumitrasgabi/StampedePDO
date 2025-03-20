<?php

class Album {
    private $id;
    private $title;
    private $artist;
    private $genre;
    private $status;
    private $db;

    public function __construct($db, $title = null, $artist = null, $genre = null) {
        $this->db = $db;
        $this->title = $title;
        $this->artist = $artist;
        $this->genre = $genre;
        $this->status = 'pending';
    }

    public function getId() {
        return $this->id;
    }

    public function save() {
        $query = "INSERT INTO albums (title, artist, genre, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([$this->title, $this->artist, $this->genre, $this->status]);
        
        if ($result) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    public function loadById($id) {
        $query = "SELECT * FROM albums WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->artist = $row['artist'];
            $this->genre = $row['genre'];
            $this->status = $row['status'];
        }
    }

    public static function getAlbumsForReview($db) {
        $query = "SELECT * FROM albums WHERE status = 'pending'";
        $stmt = $db->query($query);
        $albums = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $album = new Album($db);
            $album->loadById($row['id']);
            $albums[] = $album;
        }
        return $albums;
    }
}