<?php
//connect to mysqli
$db = mysqli_connect('localhost', 'root') or die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db,'animesite') or die(mysqli_error($db));

// take in the id of a director and return his/her full name
function get_caracter($caracter_id) {

    global $db;

    $query = 'SELECT 
            caracter_fullname 
       FROM
           caracter
       WHERE
           caracter_id = ' . $caracter_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $caracter_fullname;
}

// take in the id of a lead actor and return his/her full name
function get_leadactor($anime_leadactor) {

    global $db;

    $query = 'SELECT
            caracter_fullname
        FROM
            caracter 
        WHERE
            caracter_id = ' . $anime_leadactor;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $caracter_fullname;
}

// take in the id of a movie type and return the meaningful textual
// description
function get_animetype($animetype_id) {

    global $db;

    $query = 'SELECT 
            animetype_label
       FROM
           animetype
       WHERE
           animetype_id = ' . $animetype_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $animetype_label;
}


// retrieve information
$query = 'SELECT
        anime_id, anime_name, anime_year, anime_director,
        anime_leadactor, anime_type
    FROM
        anime
    ORDER BY
        anime_name ASC,
        anime_year DESC';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// determine number of rows in returned result
$num_animes = mysqli_num_rows($result);

$table = <<<ENDHTML
<div style="text-align: center;">
 <h2>Anime Review Database</h2>
 <table border="1" cellpadding="2" cellspacing="2"
  style="width: 70%; margin-left: auto; margin-right: auto;">
  <tr>
   <th>Anime Title</th>
   <th>Year of Release</th>
   <th>Anime Director</th>
   <th>Anime Lead Actor</th>
   <th>Anime Type</th>
  </tr>
ENDHTML;

// loop through the results

while ($row = mysqli_fetch_assoc($result)) {
    extract($row);
    $director = get_caracter($anime_director);
    $leadactor = get_leadactor($anime_leadactor);
    $animetype = get_animetype($anime_type);

    $table .= <<<ENDHTML
    <tr>
     <td><a href="PaginaDetails.php?anime_id=$anime_id&orden=review_date">$anime_name</a></td>
     <td>$anime_year</td>
     <td>$director</td>
     <td>$leadactor</td>
     <td>$animetype</td>
    </tr>
ENDHTML;
}

$table .= <<<ENDHTML
 </table>
<p>$num_animes Animes</p>
</div>
ENDHTML;

echo $table;
?>
