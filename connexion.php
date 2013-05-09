<?php
session_start();
$titre="Connexion";
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");

echo '<ul class="breadcrumb">
	<li><a href="./index.php">Forum</a> <span class="divider">/</span></li>
    <li class="active">Connexion</li>
</ul>';

echo '<h3>Connexion</h3>';
if ($id!=0) erreur(ERR_IS_CO);

if (!isset($_POST['pseudo'])) //On est dans la page de formulaire
{
    echo '<form method="post" action="connexion.php">
    <fieldset>
    <legend>Connexion</legend>
    <p>
    <label for="pseudo">Pseudo :</label><input name="pseudo" type="text" id="pseudo" /><br />
    <label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
	<input type="hidden" name="page" value="'. $_SERVER['HTTP_REFERER'] .'" />
    </p>
    </fieldset>
    <p><input type="submit" value="Connexion" /></p></form>
    <a href="./register.php">Pas encore inscrit ?</a>
      
    </div>
    </body>
    </html>';
}else
{
    $message='';
    if (empty($_POST['pseudo']) || empty($_POST['password']) ) //Oublie d'un champ
    {
        $message = '<p>une erreur s\'est produite pendant votre identification.
    Vous devez remplir tous les champs</p>
    <p>Cliquez <a href="./connexion.php">ici</a> pour revenir</p>';
    }
    else //On check le mot de passe
    {
        $query=$db->prepare('SELECT membre_mdp, membre_id, membre_rang, membre_pseudo
        FROM forum_membres WHERE membre_pseudo = :pseudo');
        $query->bindValue(':pseudo',$_POST['pseudo'], PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();
    if ($data['membre_mdp'] == md5($_POST['password'])) // Acces OK !
    {
        $_SESSION['pseudo'] = $data['membre_pseudo'];
        $_SESSION['level'] = $data['membre_rang'];
        $_SESSION['id'] = $data['membre_id'];
		$page = htmlspecialchars($_POST['page']);
        $message = '<p>Bienvenue '.$data['membre_pseudo'].',
            vous �tes maintenant connect�!</p>
            <p>Cliquez <a href="'.$page.'">ici</a> pour revenir � la page pr�c�dente</p>'; 
    }
    else // Acces pas OK !
    {
        $message = '<p>Une erreur s\'est produite
        pendant votre identification.<br /> Le mot de passe ou le pseudo
            entr� n\'est pas correcte.</p><p>Cliquez <a href="./connexion.php">ici</a>
        pour revenir � la page pr�c�dente
        <br /><br />Cliquez <a href="./index.php">ici</a>
        pour revenir � la page d accueil</p>';
    }
    $query->CloseCursor();
    }
    echo $message.'</div></body></html>';
 
}
?>