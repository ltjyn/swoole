<?php
class db
{
    public static function get_db()
    {
        return new mysqli('127.0.0.1','root','123456','dpuzzle_main',3306);
    }
}

class post
{
    private $db;
    public function __construct($db)
    {
        $this->db = new mysqli('127.0.0.1','root','123456','dpuzzle_main',3306);
    }

    public function get_post($id)
    {
        return $this->db->query("SELECT * FROM User WHERE id={$id}");
    }
}

$post = new post();
$post->get_post(1);