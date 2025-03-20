<?php
class Review {
    private $id;
    private $albumId;
    private $userId;
    private $content;
    private $rating;
    private $approved;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function setAlbumId($albumId) {
        $this->albumId = $albumId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setApproved($approved) {
        $this->approved = $approved ? 1 : 0;
    }

    public function approve() {
        $this->approved = 1;
        $stmt = $this->db->prepare("UPDATE reviews SET approved = 1 WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }

    public function save() {
        $query = "INSERT INTO reviews (album_id, user_id, content, rating, approved) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iisis", $this->albumId, $this->userId, $this->content, $this->rating, $this->approved);
        $result = $stmt->execute();
        if ($result) {
            $this->id = $this->db->insert_id;
            return true;
        } else {
            echo "Error: " . $this->db->error;
            return false;
        }
    }
}
