<?php
  $heading = "Register";
  require 'Validator.php';
  $username = 'MatheApp';
  $password = 'password';
  $config = require('config.php');
  $db = new Database($config['database'], $username, $password);
  
if (isset($_POST["submit"])) {
  $db->register($_POST);
}

  require "views/register.view.php";
