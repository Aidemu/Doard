<?php
//Cette fonction doit �tre appel�e avant tout code html
session_start();
 
//On donne ensuite un titre � la page, puis on appelle notre fichier debut.php
$titre = "Index du forum";
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");
?>
<ul class="breadcrumb">
	<li class="active">Forum</li>
    <!--<li><a href="#">Home</a> <span class="divider">/</span></li>
    <li><a href="#">Library</a> <span class="divider">/</span></li>
    <li class="active">Data</li>-->
</ul>
 
<?php
//Initialisation de deux variables
$totaldesmessages = 0;
$categorie = NULL;

//Cette requ�te permet d'obtenir tout sur le forum
$query=$db->prepare('SELECT cat_id, cat_nom,
forum_forum.forum_id, forum_name, forum_desc, forum_post, forum_topic, auth_view, forum_topic.topic_id,  forum_topic.topic_post, post_id, post_time, post_createur, membre_pseudo,
membre_id
FROM forum_categorie
LEFT JOIN forum_forum ON forum_categorie.cat_id = forum_forum.forum_cat_id
LEFT JOIN forum_post ON forum_post.post_id = forum_forum.forum_last_post_id
LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
LEFT JOIN forum_membres ON forum_membres.membre_id = forum_post.post_createur
WHERE auth_view <= :lvl
ORDER BY cat_ordre, forum_ordre DESC');
$query->bindValue(':lvl',$lvl,PDO::PARAM_INT);
$query->execute();
?>
<table class="table table-hover">
<?php
//D�but de la boucle
while($data = $query->fetch())
{
    //On affiche chaque cat�gorie
    if( $categorie != $data['cat_id'] )
    {
        //Si c'est une nouvelle cat�gorie on l'affiche
        
        $categorie = $data['cat_id'];
        ?>
        <thead>
        <th></th>
        <th class="titre"><strong><?php echo stripslashes($data['cat_nom']); ?>
        </strong></th>            
        <th class="nombremessages"><span class="badge badge-important"><strong>Sujets</strong></span></th>      
        <th class="nombresujets"><span class="badge badge-important"><strong>Messages</strong></span></th>      
        <th class="derniermessage"><span class="badge badge-important"><strong>Dernier message</strong></span></th>  
        </thead>
        <?php
                
    }
 
    //Ici, on met le contenu de chaque cat�gorie
    // Ce super echo de la mort affiche tous
    // les forums en d�tail : description, nombre de r�ponses etc...
 
    echo'<tr><td><img src="./images/message.gif" alt="message" /></td>
    <td class="titre"><strong>
    <a href="./voirforum.php?f='.$data['forum_id'].'">
    '.stripslashes($data['forum_name']).'</a></strong>
    <br />'.nl2br(stripslashes($data['forum_desc'])).'</td>
    <td class="nombresujets">'.$data['forum_topic'].'</td>
    <td class="nombremessages">'.$data['forum_post'].'</td>';
 
    // Deux cas possibles :
    // Soit il y a un nouveau message, soit le forum est vide
    if (!empty($data['forum_post']))
    {
         //Selection dernier message
     $nombreDeMessagesParPage = 15;
         $nbr_post = $data['topic_post'] +1;
     $page = ceil($nbr_post / $nombreDeMessagesParPage);
          
         echo'<td class="derniermessage">
         '.date('H\hi \l\e d/M/Y',$data['post_time']).'<br />
         <a href="./voirprofil.php?m='.stripslashes(htmlspecialchars($data['membre_id'])).'&amp;action=consulter">'.$data['membre_pseudo'].'  </a>
         <a href="./voirtopic.php?t='.$data['topic_id'].'&amp;page='.$page.'#p_'.$data['post_id'].'">
         <img src="./images/go.gif" alt="go" /></a></td></tr>';
 
     }
     else
     {
         echo'<td class="nombremessages">Pas de message</td></tr>';
     }
 
     //Cette variable stock le nombre de messages, on la met � jour
     $totaldesmessages += $data['forum_post'];
 
     //On ferme notre boucle et nos balises
} //fin de la boucle
$query->CloseCursor();
echo '</table></div>';
include("includes/footer.php");
?>

</div>
</body>
</html>