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

require_once('Model/Repository/DisclaimerGestionTable.php');



//  création de la fonction ajouter au menu
function ajouterAuMenu()
{
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

if (class_exists("DisclaimerGestionTable")) {
    $gerer_table = new DisclaimerGestionTable();
}

if (isset($gerer_table)) {
    //création de la table en bdd lors de l'activation
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable'));
    //suppression de la table en bdd lors de la désactivation
    register_deactivation_hook(__FILE__, array($gerer_table, 'supprimerTable'));
}

// Hook pour réaliser l'action 'admin_menu' <- emplacement / ajouterAuMenu <- fonction à appeler / <- priorité.
add_action("admin_menu", "ajouterAuMenu", 10);

// Fonction à appeler lorsqu'on clique sur le menu
function disclaimerFonction()
{
    require_once('views/disclaimer-menu.php');
}

add_action('init', 'inserer_js_dans_footer');

function inserer_js_dans_footer()
{
    if (!is_admin()) :
        wp_register_script(
            'jQuery',
            'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
            null,
            null,
            true
        );
        wp_enqueue_script('jQuery');
        wp_register_script(
            'jQuery_modal',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js',
            null,
            null,
            true
        );
        wp_enqueue_script('jQuery_modal');
        wp_register_script(
            'jQuery_eu',
            plugins_url('assets/js/eu-disclaimer.js', __FILE__),
            array('jquery'),
            '1.1',
            true
        );
        wp_enqueue_script('jQuery_eu');
    endif;
}

add_action('wp_head', 'ajouter_css', 1);

function ajouter_css()
{
    if (!is_admin()) :
        wp_register_style(
            'eu-disclaimer-css',
            plugins_url('assets/css/eu-disclaimer-css.css', __FILE__),
            null,
            null,
            false
        );
        wp_enqueue_style('eu-disclaimer-css');
        wp_register_style(
            'modal',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css',
            null,
            null,
            false
        );
        wp_enqueue_style('modal');
    endif;
}

/////////////////////////////////////////////
/////////////  Affichage      ///////////////
/////////////  systématique  ///////////////
/////////////////////////////////////////////

add_action('wp_body_open', 'afficheModalDansBody');

function afficheModalDansBody()
{
    echo DisclaimerGestionTable::AfficherDonneModal();
}

/////////////////////////////////////////////
/////////////  Affichage      ///////////////
/////////////  via SHORTCODE  ///////////////
/////////////////////////////////////////////

//  Pour afficher la MODAL à un endroit donné, il faut ajouter [eu-disclaimer] dans l'endroit souhaité //


//add_shortcode('eu-disclaimer', 'afficheModal');

/*function afficheModal()
{
    return DisclaimerGestionTable::AfficherDonneModal();
}*/



