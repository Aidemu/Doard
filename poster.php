<?php
session_start();
$titre="Poster";
$balises = true;
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");

//Qu'est ce qu'on veut faire ? poster, répondre ou éditer ?
$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'';
 
//Il faut être connecté pour poster !
if ($id==0) erreur(ERR_IS_CO);
 
//Si on veut poster un nouveau topic, la variable f se trouve dans l'url,
//On récupère certaines valeurs
if (isset($_GET['f']))
{
    $forum = (int) $_GET['f'];
    $query= $db->prepare('SELECT forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
    FROM forum_forum WHERE forum_id =:forum');
    $query->bindValue(':forum',$forum,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
	
	echo '<ul class="breadcrumb">
		<li><a href="./index.php">Forum</a> <span class="divider">/</span></li>
		<li><a href="./voirforum.php?f='.$forum.'">'.stripslashes($data['forum_name']).'</a> <span class="divider">/</span></li>
		<li class="active">Nouveau topic</li>
	</ul>';
 
  
}
  
//Sinon c'est un nouveau message, on a la variable t et
//On récupère f grâce à une requête
elseif (isset($_GET['t']))
{
    $topic = (int) $_GET['t'];
    $query=$db->prepare('SELECT topic_titre, forum_topic.forum_id,
    forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
    FROM forum_topic
    LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
    WHERE topic_id =:topic');
    $query->bindValue(':topic',$topic,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
    $forum = $data['forum_id']; 
	
		echo '<ul class="breadcrumb">
			<li><a href="./index.php">Forum</a> <span class="divider">/</span></li>
			<li><a href="./voirforum.php?f='.$forum.'">'.stripslashes($data['forum_name']).'</a> <span class="divider">/</span></li>
			<li><a href="./voirtopic.php?t='.$topic.'">'.stripslashes($data['topic_titre']).'</a> <span class="divider">/</span></li>
			<li class="active">Répondre</li>
		</ul>';
}
  
//Enfin sinon c'est au sujet de la modération(on verra plus tard en détail)
//On ne connait que le post, il faut chercher le reste
elseif (isset ($_GET['p']))
{
    $post = (int) $_GET['p'];
    $query=$db->prepare('SELECT post_createur, forum_post.topic_id, topic_titre, forum_topic.forum_id,
    forum_name, auth_view, auth_post, auth_topic, auth_annonce, auth_modo
    FROM forum_post
    LEFT JOIN forum_topic ON forum_topic.topic_id = forum_post.topic_id
    LEFT JOIN forum_forum ON forum_forum.forum_id = forum_topic.forum_id
    WHERE forum_post.post_id =:post');
    $query->bindValue(':post',$post,PDO::PARAM_INT);
    $query->execute();
    $data=$query->fetch();
 
    $topic = $data['topic_id'];
    $forum = $data['forum_id'];
  
    echo '<p><i>Vous êtes ici</i> : <a href="./index.php">Index du forum</a> -->
    <a href="./voirforum.php?f='.$data['forum_id'].'">'.stripslashes(htmlspecialchars($data['forum_name'])).'</a>
    --> <a href="./voirtopic.php?t='.$topic.'">'.stripslashes(htmlspecialchars($data['topic_titre'])).'</a>
    --> Modérer un message</p>';
}
$query->CloseCursor();  

switch($action)
{
case "repondre": //Premier cas on souhaite répondre
?>
<h1>Poster une réponse</h1>
  
<form method="post" action="postok.php?action=repondre&amp;t=<?php echo $topic ?>" name="formulaire">
  
<fieldset><legend>Message</legend>
<textarea cols="80" rows="8" id="message" name="message"></textarea>
</fieldset>
<br />
<input type="submit" name="submit" value="Envoyer" class="btn" />
</p></form>
<?php
break;
  
case "nouveautopic":
?>
  
<h1>Nouveau topic</h1>
<form method="post" action="postok.php?action=nouveautopic&amp;f=<?php echo $forum ?>" name="formulaire">
  
<fieldset><legend>Titre</legend>
<input type="text" size="80" id="titre" name="titre" /></fieldset>
  
<fieldset><legend>Message</legend>
<textarea cols="80" rows="8" id="message" name="message"></textarea>
<label><input type="radio" name="mess" value="Annonce" />Annonce</label>
<label><input type="radio" name="mess" value="Message" checked="checked" />Topic</label>
</fieldset>
<br />
<p>
<input type="submit" name="submit" value="Envoyer" class="btn" />
</form>
<?php
break;

default: //Si jamais c'est aucun de ceux là c'est qu'il y a eu un problème :o
echo'<p>Cette action est impossible</p>';
} //Fin du switch
?>
</div>
<script>
    CKEDITOR.replace( 'message' );
</script>
</body>
</html>