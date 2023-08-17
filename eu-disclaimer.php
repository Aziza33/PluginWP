<?php
// l'ajout de ces lignes est obligatoire et permettra d'afficher mon module dans le panel administration des extensions

/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://URL_de_l_extension
 * Description: Plugin sur la législation des produits à base de nicotine.
 * Version: 1.5
 * Author: Aziza AFPA 
 * Author URI: http://www.afpa.fr 
 * License (Lien de la licence)
 */ 

 require_once ('Model/Repository/DisclaimerGestionTable.php');

 if (class_exists("DisclaimerGestionTable")){
    $gerer_table = new DisclaimerGestionTable();
 }
 if (isset($gerer_table)){
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable'));
    register_desactivation_hook(__FILE__, array($gerer_table, 'supprimerTable'));
 }

//  création de la fonction ajouter au menu
 function ajouterAuMenu(){
    $page = 'eu-disclaimer';
    $menu = 'eu-disclaimer';
    $capability = 'edit_pages';
    $slug = 'eu-disclaimer';
    $function = 'disclaimerFonction';
    $icon = "";
    $position = 80; // L'entrée dans les menus sera en dessous de Réglages comme prévu dans la liste des positions par défaut
    if (is_admin()) {
        add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }
}

// Hook pour réaliser l'action 'admin_menu' <- emplacement / ajouterAuMenu <- fonction à appeler / <- priorité.
    add_action("admin_menu", "ajouterAuMenu", 10);

// Fonction à appeler lorsqu'on clique sur le menu
function disclaimerFonction() {
    require_once ('views/disclaimer-menu.php');
}


