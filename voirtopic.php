<?php
session_start();
$titre="Voir un sujet";
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");
  
//On r�cup�re la valeur de t
$topic = (int) $_GET['t'];
  
//A partir d'ici, on va compter le nombre de messages pour n'afficher que les 15 premiers
$query=$db->prepare('SELECT topic_titre, topic_post, forum_topic.forum_id, topic_last_post,
forum_name, auth_view, auth_topic, auth_post
FROM forum_topic
LEFT JOIN forum_forum ON forum_topic.forum_id = forum_forum.forum_id
WHERE topic_id = :topic');
$query->bindValue(':topic',$topic,PDO::PARAM_INT);
$query->execute();
$data=$query->fetch();
$forum=$data['forum_id'];
$totalDesMessages = $data['topic_post'] + 1;
$nombreDeMessagesParPage = 15;
$nombreDePages = ceil($totalDesMessages / $nombreDeMessagesParPage);

echo '<ul class="breadcrumb">
	<li><a href="./index.php">Forum</a> <span class="divider">/</span></li>
	<li><a href="./voirforum.php?f='.$forum.'">'.stripslashes($data['forum_name']).'</a> <span class="divider">/</span></li>
    <li class="active">'.stripslashes($data['topic_titre']).'</li>
</ul>';

//Nombre de pages
$page = (isset($_GET['page']))?intval($_GET['page']):1;
 
//On affiche les pages 1-2-3 etc...
echo '<p>Page : ';
for ($i = 1 ; $i <= $nombreDePages ; $i++)
{
    if ($i == $page) //On affiche pas la page actuelle en lien
    {
    echo $i;
    }
    else
    {
    echo '<a href="voirtopic.php?t='.$topic.'&page='.$i.'">
    ' . $i . '</a> ';
    }
}
echo'</p>';
  
$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;
 
  
//On affiche l'image r�pondre
echo'<a href="./poster.php?action=repondre&amp;t='.$topic.'" class="btn">R�pondre</a>';
  
$query->CloseCursor();
//Enfin on commence la boucle !

$query=$db->prepare('SELECT post_id , post_createur , post_texte , post_time ,
membre_id, membre_pseudo, membre_inscrit, membre_avatar, membre_localisation, membre_post, membre_signature
FROM forum_post
LEFT JOIN forum_membres ON forum_membres.membre_id = forum_post.post_createur
WHERE topic_id =:topic
ORDER BY post_id
LIMIT :premier, :nombre');
$query->bindValue(':topic',$topic,PDO::PARAM_INT);
$query->bindValue(':premier',(int) $premierMessageAafficher,PDO::PARAM_INT);
$query->bindValue(':nombre',(int) $nombreDeMessagesParPage,PDO::PARAM_INT);
$query->execute();
  
//On v�rifie que la requ�te a bien retourn� des messages
if ($query->rowCount()<1)
{
        echo'<p>Il n y a aucun post sur ce topic, v�rifiez l url et reessayez</p>';
}
else
{
        //Si tout roule on affiche notre tableau puis on remplit avec une boucle
        ?>
		
		<table class="table">
        <thead>
        <th class="vt_auteur" width=14%><span class="badge badge-important"><strong>Auteurs</strong></span></th>            
        <th class="vt_mess"><span class="badge badge-important"><strong>Messages</strong></span></th>      
        </thead>
        <?php
        while ($data = $query->fetch())
        {
		//On commence � afficher le pseudo du cr�ateur du message :
         //On v�rifie les droits du membre
         //(partie du code comment�e plus tard)
         echo'<tr><td><strong>
         <a href="./voirprofil.php?m='.$data['membre_id'].'&amp;action=consulter">
         '.stripslashes($data['membre_pseudo']).'</a></strong></td>';
            
         /* Si on est l'auteur du message, on affiche des liens pour
         Mod�rer celui-ci.
         Les mod�rateurs pourront aussi le faire, il faudra donc revenir sur
         ce code un peu plus tard ! */    
    
         if ($id == $data['post_createur'])
         {
         echo'<td id=p_'.$data['post_id'].'>Post� � '.date('H\hi \l\e d M y',$data['post_time']).'
         <a href="./poster.php?p='.$data['post_id'].'&amp;action=delete">
         <img src="./images/supprimer.gif" alt="Supprimer"
         title="Supprimer ce message" /></a>  
         <a href="./poster.php?p='.$data['post_id'].'&amp;action=edit">
         <img src="./images/editer.gif" alt="Editer"
         title="Editer ce message" /></a></td></tr>';
         }
         else
         {
         echo'<td>
         Post� � '.date('H\hi \l\e d M y',$data['post_time']).'
         </td></tr>';
         }
        
         //D�tails sur le membre qui a post�
         echo'<tr><td>
         <img src="./public/avatars/'.$data['membre_avatar'].'" alt="" />
         <br />Membre inscrit le '.date('d/m/Y',$data['membre_inscrit']).'
         <br />Messages : '.$data['membre_post'].'<br />
         Localisation : '.stripslashes($data['membre_localisation']).'</td>';
                
         //Message
         echo'<td>'.nl2br(stripslashes($data['post_texte'])).'
         <br /><hr />'.nl2br(stripslashes($data['membre_signature'])).'</td></tr>';
         } //Fin de la boucle ! \o/
         $query->CloseCursor();
 
         ?>
</table>
<?php
        echo '<p>Page : ';
        for ($i = 1 ; $i <= $nombreDePages ; $i++)
        {
                if ($i == $page) //On affiche pas la page actuelle en lien
                {
                echo $i;
                }
                else
                {
                echo '<a href="voirtopic.php?t='.$topic.'&amp;page='.$i.'">
                ' . $i . '</a> ';
                }
        }
        echo'</p>';
        
        //On ajoute 1 au nombre de visites de ce topic
        $query=$db->prepare('UPDATE forum_topic
        SET topic_vu = topic_vu + 1 WHERE topic_id = :topic');
        $query->bindValue(':topic',$topic,PDO::PARAM_INT);
        $query->execute();
        $query->CloseCursor();
	echo'<a href="./poster.php?action=repondre&amp;t='.$topic.'" class="btn">R�pondre</a>';

} //Fin du if qui v�rifiait si le topic contenait au moins un message
?>          
</div>
</body>
</html>