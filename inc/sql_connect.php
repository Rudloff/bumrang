<?php
/**
 * SQL connection
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
require "config.php";
$sql=new PDO(
    "mysql:dbname=".$config->sql_db.";host=".$config->sql_host,
    $config->sql_user, $config->sql_password
);
$sql->query("SET NAMES 'utf8';") or die(mysql_error());
?>
