<?php

// on appelle le fichier
require_once('disclaimer-menu.php');

// on ajoute une action en utilisant ce hook pour lier la fonction disclaimerFonction() à wordpress
add_action('eu-disclaimer', 'disclaimerFonction', 10);

