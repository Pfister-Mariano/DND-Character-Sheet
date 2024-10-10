<?php
/**
 * CONFIG FILE - gemeinsame projektweite Config Values
 */
define('SESSION_LIFETIME', 1); // Gültigkeit der Login Session in Minuten
define('SESSIONCOOKIE_NAME', md5('EIGENERNAME')); // eigener session name, wird als Hash genutzt

$isLoggedIn = false; 
$hasError = false; // noch keine Fehler
$errorMessages = array();

$baseUrl = 'https://character-sheet.mariano-pfister.ch'; 
$valid_username = 'Schnödögürügönggöng';
$hashed_password = '$2y$10$3ZiAgXBw4IwFhjhbrS/jxem0CEnRdFIzhbZymWkwZ77QspMS2NwZu';
?>