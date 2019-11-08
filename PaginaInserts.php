<?php
// connect to mysqli
$db = mysqli_connect('localhost', 'root') or die ('Unable to connect.
Check your connection parameters.');
//make sure you're using the correct database
mysqli_select_db($db,'animesite') or die(mysqli_error($db));
// insert data into the movie table
$query = 'INSERT INTO anime
(anime_id, anime_name, anime_type, anime_year, anime_leadactor,
anime_director)
VALUES
(1, "Kimetsu no Yaiba", 1, 2018, 1, 2),
(2, "Nanatsu no taizai", 2, 2016, 5, 6),
(3, "Shokugeki no souma", 3, 2017, 4, 3)';
mysqli_query($db,$query) or die(mysqli_error($db));
// insert data into the movietype table
$query = 'INSERT INTO animetype
(animetype_id, animetype_label)
VALUES
(1,"Shonen"),
(2, "Romance"),
(3, "Sports"),
(4, "Mecha"),
(5, "Comedy"),
(6, "Horror"),
(7, "Isekai"),
(8, "Fantasy")';
mysqli_query($db,$query) or die(mysqli_error($db));
// insert data into the people table
$query = 'INSERT INTO caracter
(caracter_id, caracter_fullname, caracter_isactor, caracter_isdirector)
VALUES
(1, "Kamado Tanjiro", 1, 0),
(2, "Sawada Tsunayoshi", 0, 1),
(3, "Hibari Kyoya", 0, 1),
(4, "Soma Yukihira", 1, 0),
(5, "Meliodas", 1, 0),
(6, "Yamamoto Takeshi", 0, 1)';
mysqli_query($db,$query) or die(mysqli_error($db));
echo 'Data inserted successfully!';
?>