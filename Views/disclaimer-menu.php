



<?php
// On vérifie que les champs 'message_disclaimer' et 'url_redirection' ne soient pas vides 
if (!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])) {

    // on crée un nouvel objet de type DisclaimerOptions
    $text = new DisclaimerOptions();
    $text->setMessage_disclaimer(htmlspecialchars($_POST['message_disclaimer']));

    // A VOIR ET CORRIGER
    $text->setRedirection_ko(htmlspecialchars ($_POST['url_redirection']));
    $message = DisclaimerGestionTable::insererDansTable($text);
}

// on appelle le fichier
// PAS BESOIN require_once('disclaimer-menu.php');

// on ajoute une action en utilisant ce hook pour lier la fonction disclaimerFonction() à wordpress
add_action('eu-disclaimer', 'disclaimerFonction', 10);





?>

<p><? /*php if(isset($message)) echo $message; */?></p>

<h1>EU DISCLAIMER</h1>
<br>
<h2>Configuration</h2>
<p><?= $message ?? '' ?></p>
<form method="post" action=""  novalidate="novalidate">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="blogname">Message du disclaimer</label></th>
           <td><input name="message_disclaimer" type="text" id="message_disclaimer"  value="" class="regular-text"/></td> 
        </tr>
        <tr>
            <th scope="row"><label for="blogname">Url de redirection</label></th>
            <td><input name="url_redirection" type="text" id="url_redirection" value="" class="regular-text"/></td>
        </tr>

    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modifications"/></p>
</form>
<br>
<p>La législation nous impose de vous informer sur la nocivité des produits à base de nicotine, vous devez avoir plus de 18 ans pour consulter ce site !</p>
<br>
<h3>Centre Afpa / session DWWM</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/img/logo.jpg'; ?>" width="10%" alt="logo">

<div>
    <p> Comment afficher le plug-in ?</p>
    <p>Ajoutez ce code php sous la balise body html : 
    <br>
    echo do_shortcode('[eu-disclaimer]');
    </p>
</div>



 <?php /*
$text = new DisclaimerOptions();
$text->setMessage_disclaimer($_POST['message_disclaimer']);
$text->setRedirection_ko($_POST['url_redirection']);
DisclaimerGestionTable::insererDansTable($text->getMessage_disclaimer(), $text->getRedirection_ko());*/?>





