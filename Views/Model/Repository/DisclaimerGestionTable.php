<?php

// Définition du chemin d'accès à la classe DisclaimerOptions 
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
include( MY_PLUGIN_PATH . '../Entity/DisclaimerOptions.php');

class DisclaimerGestionTable {

    public function creerTable(){
    // instanciation de la classe DisclaimerOptions
        $message = new DisclaimerOptions();

    // on alimente l'objet message avec les valeurs par défaut grâce au setter (mutateur)
        $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visiter ce site.");
        $message->setRedirectionko("https://www.google.com/");
        global $wpdb;

    // création de la table
        $tableDisclaimer = $wpdb->prefix.'disclaimer_options';
            if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) {
                $sql = "CREATE TABLE $tableDisclaimer (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, message_disclaimer TEXT NOT NULL, redirection_ko TEXT NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; ";
   
    // Message d'erreur

            if (!$wpdb->query($sql))
            {
                die("Une erreur est survenue, contactez le développeur du plugin...");
            }

    //  Insertion du message par défaut
        $wpdb->insert($wpdb->prefix . 'disclaimer_options', array('message_disclaimer' => $message->getMessageDisclaimer(), 'redirection_ko' => $message->getRedirectionko(), ), array('%s', '%s')); 
        $wpdb->query($sql);
            }
        
    }

    public function supprimerTable(){
        // $wpdb sert à récupérer l'objet contenant les informations relatives à la base de données.
        global $wpdb;
        $table_disclaimer = $wpdb->prefix."disclaimer_options";
        $sql = "DROP TABLE $table_disclaimer";
        $wpdb->query($sql);
    }

}