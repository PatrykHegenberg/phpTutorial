<?php
  $username = 'MatheApp';
  $password = 'password';
  $config = require('config.php');
  $db = new Database($config['database'], $username, $password);
  $data = json_decode(file_get_contents("php://input"), true);
  $db->query("UPDATE user SET level= :level, xp= :xp, coins= :coins WHERE username = :user", [
  "level" => $data["level"],
  "xp" => $data["xp"],
  "coins" => $data["coins"],
  "user" => $data["username"]
]);
