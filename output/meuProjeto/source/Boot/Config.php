<?php

date_default_timezone_set("America/Sao_Paulo");

#################
##   PROJECT   ##
#################

define("CONF_VIEW_APP", "agenda");

define("CONF_URL_BASE", "https://www.localhost/agendaweb");
define("CONF_URL_TEST", "https://www.localhost/agendaweb");

define("CONF_VIEW_PATH", "");
define("CONF_VIEW_EXT", "php");


define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "agendaweb",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
