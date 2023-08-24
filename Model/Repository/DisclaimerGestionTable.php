<?php

// Définition du chemin d'accès à la classe DisclaimerOptions 
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
include(MY_PLUGIN_PATH . '../Entity/DisclaimerOptions.php');

class DisclaimerGestionTable
{

    static function AfficherDonneModal()
    {
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix . "disclaimer_options";
        $row = $wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        $lien_redirection = $row->redirection_ko;
        //$lien_redirection = "https://sante.gouv.fr/prevention-en-sante/addictions/produits-de-vapotage-cigarette-electronique/article/les-produits-de-vapotage-cigarette-electronique"

        // echo '<div id="monModal" class="modal"> 
        return '<div id="monModal" class="modal"> 
        <p>Le Vapobar vous souhaite la bienvenue ! <br> Pour continuer, la législation européenne nous oblige à vérifier que vous êtes majeur.</p>
        <p>' . $message_disclaimer . '</p><a href="' . $lien_redirection . '" 
        type="button" class="btn-red">Non</a>
        <a href="#" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui</a>      
        </div>';
    }


    public function creerTable()
    {
        // instanciation de la classe DisclaimerOptions
        $message = new DisclaimerOptions();

        // on alimente l'objet message avec les valeurs par défaut grâce au setter (mutateur)
        $message->setMessage_disclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans 
        pour visiter ce site.");
        $message->setRedirection_ko("https://www.google.fr/");
        global $wpdb;

        // création de la table
        $tableDisclaimer = $wpdb->prefix . 'disclaimer_options';
        if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) {
            // la table n'existe pas déjà
            $sql = "CREATE TABLE $tableDisclaimer 
                (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                 message_disclaimer TEXT NOT NULL, 
                 redirection_ko TEXT NOT NULL) 
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; ";

            // Message d'erreur

            if (!$wpdb->query($sql)) {
                die("Une erreur est survenue, contactez le développeur du plugin...");
            }

            //  Insertion du message par défaut
            $wpdb->insert(
                $wpdb->prefix . 'disclaimer_options',
                array(
                    'message_disclaimer' => $message->getMessage_disclaimer(),
                    'redirection_ko' => $message->getRedirection_ko()
                    //'redirection_ok' => 'URL01'
                ),
                array('%s', '%s')
            );

            //$wpdb->query($sql);
        }
    }

    public function supprimerTable()
    {
        // $wpdb sert à récupérer l'objet contenant les informations relatives à la base de données.
        global $wpdb;
        $table_disclaimer = $wpdb->prefix . "disclaimer_options";
        $sql = "DROP TABLE $table_disclaimer";
        $wpdb->query($sql);
    }

    static function insererDansTable(DisclaimerOptions $option)
    {
        
        global $wpdb;
        try {
            $table_disclaimer = $wpdb->prefix . 'disclaimer_options';
            $sql = $wpdb->prepare(
                "
            UPDATE $table_disclaimer 
            SET message_disclaimer = '%s', redirection_ko = '%s' 
            WHERE id_disclaimer = %s",
                $option->getMessage_disclaimer(),
                $option->getRedirection_ko(),
                1
            );

            //$contenu,$url,1 
            //);
            $wpdb->query($sql);
            return '<span style="color:green; font-size:16px;">Les données ont correctement été mises à jour !</span>';
        } catch (Exception $e) {
            return '<span style="color:red; font-size:16px;">Une erreur est survenue !<span>';
        }
    }
}
