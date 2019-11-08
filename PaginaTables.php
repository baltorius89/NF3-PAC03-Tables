<?php
//connect to MySQL
$db = mysqli_connect('localhost', 'root') or die ('Unable to connect.
Check your connection parameters.');
//create the main database if it doesn't already exist
$query = 'CREATE DATABASE IF NOT EXISTS animesite';
mysqli_query($db,$query) or die(mysqli_error($db));
//make sure our recently created database is the active one
mysqli_select_db($db,'animesite') or die(mysqli_error($db));
//create the movie table
$query = 'CREATE TABLE anime (
anime_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
anime_name VARCHAR(255) NOT NULL,
anime_type TINYINT NOT NULL DEFAULT 0,
anime_year SMALLINT UNSIGNED NOT NULL DEFAULT 0,
anime_leadactor INTEGER UNSIGNED NOT NULL DEFAULT 0,
anime_director INTEGER UNSIGNED NOT NULL DEFAULT 0,
PRIMARY KEY (anime_id),
KEY movie_type (anime_type, anime_year)
) 
ENGINE=MyISAM';
mysqli_query($db,$query) or die (mysqli_error($db));



//create the movietype table
$query = 'CREATE TABLE animetype (
animetype_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
animetype_label VARCHAR(100) NOT NULL,
PRIMARY KEY (animetype_id)
) 
ENGINE=MyISAM';
mysqli_query($db,$query) or die(mysqli_error($db));

$query = 'CREATE TABLE caracter ( 
caracter_id         INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
caracter_fullname   VARCHAR(255)        NOT NULL, 
caracter_isactor    TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, 
caracter_isdirector TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, 
PRIMARY KEY (caracter_id)
    ) 
    ENGINE=MyISAM';
mysqli_query($db,$query) or die(mysqli_error($db));
echo 'Movie database successfully created!';
?>