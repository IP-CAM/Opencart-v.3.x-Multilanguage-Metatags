<meta charset="utf-8">
<?php
error_reporting(-1);
require_once 'config.php';

$host = DB_HOSTNAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;
$dbname = DB_DATABASE;
$pr = DB_PREFIX;

try {
    $dbh = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $pass);
    $dbh->exec('SET NAMES utf8');
} catch (PDOException $e) {
    echo $e->getMessage();
}

$query = $this->dbh->query("SELECT * FROM `" . DB_PREFIX . "language`");

if($query->num_rows && !isset($query->row['url'])) {
    $this->dbh->query("ALTER TABLE `" . DB_PREFIX . "language` ADD `url` VARCHAR(32) NOT NULL AFTER `code`");
}

$stmt = $dbh->prepare('CREATE TABLE IF NOT EXISTS `oc_unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `symbol_rus` varchar(20) DEFAULT NULL,
  `symbol_ukr` varchar(20) DEFAULT NULL,
  `symbol_intl` varchar(20) DEFAULT NULL,
  `symbol_letter_intl` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;');
$stmt->execute();

$php_v = phpversion();
if ((float)$php_v < 5.6) {
    echo '<strong style="color: #FF0000;">Attention !</strong> module Units of measurement works with <strong style="color: #008000;">PHP 5.6</strong> or later <strong style="color: #FF0000;">PHP ' . $php_v . '</strong> For work you need PHP 5.6 or later.';
} else {
    echo 'Module Multilang OC 3 installed!';
}

?>