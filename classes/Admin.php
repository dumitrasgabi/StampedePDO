<?php
class Admin {
    private $id;
    private $username;
    private $db;

    public function __construct($db, $username) {
        $this->db = $db;
        $this->username = $username;
    }

    public function approveReview($review) {
        if ($review instanceof Review) {
            $review->approve();
        }
    }
}
