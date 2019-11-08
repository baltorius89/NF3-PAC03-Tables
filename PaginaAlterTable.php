<?php
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'animesite') or die(mysqli_error($db));

//alter the movie table to include running time, cost and takings fields
$query = 'ALTER TABLE anime ADD COLUMN (
    anime_running_time TINYINT UNSIGNED NULL,
    anime_cost         DECIMAL(4,1)     NULL,
    anime_takings      DECIMAL(4,1)     NULL)';
mysqli_query($db, $query) or die (mysqli_error($db));

//insert new data into the movie table for each movie
$query = 'UPDATE anime SET
        anime_running_time = 101,
        anime_cost = 81,
        anime_takings = 242.6
    WHERE
        anime_id = 1';
mysqli_query($db, $query) or die(mysqli_error($db));

$query = 'UPDATE anime SET
        anime_running_time = 89,
        anime_cost = 10,
        anime_takings = 10.8
    WHERE
        anime_id = 2';
mysqli_query($db, $query) or die(mysqli_error($db));

$query = 'UPDATE anime SET
        anime_running_time = 134,
        anime_cost = NULL,
        anime_takings = 33.2
    WHERE
        anime_id = 3';
mysqli_query($db, $query) or die(mysqli_error($db));

echo 'Anime database successfully updated!';
?>
