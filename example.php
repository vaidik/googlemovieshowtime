<?php

require_once 'GoogleMovieShowtimes.php';

//Create GoogleMovieShowtimes object.
//Requests www.google.com/movies
$test = new GoogleMovieShowtimes();
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

//Requests www.google.com/movies?near=washington
$test = new GoogleMovieShowtimes('washington');
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

//Requests www.google.com/movies?near=washington&mid=40ab4f3ff42e4b3
$test = new GoogleMovieShowtimes('washington', '40ab4f3ff42e4b3');
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

//Requests www.google.com/movies?mid=40ab4f3ff42e4b3
$test = new GoogleMovieShowtimes(NULL, '40ab4f3ff42e4b3');
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

//Requests www.google.com/movies?mid=40ab4f3ff42e4b3&tid=d749699868e1626e
$test = new GoogleMovieShowtimes(NULL, '40ab4f3ff42e4b3', 'd749699868e1626e');
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

//Requests www.google.com/movies?near=washington&tid=d749699868e1626e
$test = new GoogleMovieShowtimes('washington', NULL, 'd749699868e1626e');
//var_dump() the response which was parsed into a giant organized associative array.
var_dump($test->parse());

?>
