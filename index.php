<?php

$EMAIL_ID = 976583868; // 9-digit integer value (i.e., 123456789)
$API_KEY = "f55dd570"; // API key (string) provided by Open Movie DataBase (i.e., "ab123456")

session_start(); // Connect to the existing session

require_once '/home/common/php/dbInterface.php'; // Add database functionality
require_once '/home/common/php/mail.php'; // Add email functionality
require_once '/home/common/php/p4Functions.php'; // Add Project 4 base functions

processPageRequest(); // Call the processPageRequest() function

// DO NOT REMOVE OR MODIFY THE CODE OR PLACE YOUR CODE ABOVE THIS LINE

function addMovieToCart($imdbID)
{
    $userId = $_SESSION["userId"];
    $movieValue = movieExistsInDB($imdbID);

    if($movieValue == 0){
        $result= file_get_contents('http://www.omdbapi.com/?apikey='.$GLOBALS['API_KEY'].'&i='.$imdbID.'&type=movie&r=json');
        $movieInfo = json_decode($result, true);
        $imdbId = $movieInfo["imdbID"];
        $title = $movieInfo["Title"];
        $year = $movieInfo["Year"];
        $rating = $movieInfo["imdbRating"];
        $runtime = $movieInfo["Runtime"];
        $genre = $movieInfo["Genre"];
        $actors = $movieInfo["Actors"];
        $director = $movieInfo["Director"];
        $writer = $movieInfo["Writer"];
        $plot = $movieInfo["Plot"];
        $poster = $movieInfo["Poster"];
        $movieValue = addMovie($imdbId, $title, $year, $rating, $runtime, $genre, $actors, $director, $writer, $plot, $poster);
    }
    addMovieToShoppingCart($userId, $movieValue);
    displayCart();

}

function displayCart()
{
    $userId = $_SESSION["userId"];
	$movies = getMoviesInCart($userId);
    require_once './templates/cart_form.html';

}

function processPageRequest()
{
    if (empty($_SESSION["displayName"])) {
        header("Location: logon.php");
    }

    if (empty($_GET['action'])) {
        displayCart();
    }
        if ($_GET != null && $_GET['action'] == 'add') {
            addMovieToCart($_GET['imdb_id']);
            header("Location: index.php");
        }
        if ($_GET != null && $_GET['action'] == 'remove') {
            removeMovieFromCart($_GET['movie_id']);
            header("Location: index.php");
        }
}

function removeMovieFromCart($movieID)
{
    $userID = $_SESSION["userId"];

    $boolTest = removeMovieFromShoppingCart($userID, $movieID);
    if($boolTest == true)
    {
        header("Location: index.php");
    }
    else{
        header("Location: index.php");
        echo "Wrong Movie ID was used!";
    }

}
?>