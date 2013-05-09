<?php
//Le pied de page ici :
echo'<div id="footer">
<h3>
Qui est en ligne ?
</h3>
';
 
//On compte les membres
$TotalDesMembres = $db->query('SELECT COUNT(*) FROM forum_membres')->fetchColumn();
$query->CloseCursor();  
$query = $db->query('SELECT membre_pseudo, membre_id FROM forum_membres ORDER BY membre_id DESC LIMIT 0, 1');
$data = $query->fetch();
$derniermembre = stripslashes(htmlspecialchars($data['membre_pseudo']));
 
echo'<p>Le total des messages du forum est <span class="badge badge-important"><strong>'.$totaldesmessages.'</strong></span>.<br />';
echo'Le site et le forum comptent <span class="badge badge-important"><strong>'.$TotalDesMembres.'</strong></span> membres.<br />';
echo'Le dernier membre est <a href="./voirprofil.php?m='.$data['membre_id'].'&amp;action=consulter">'.$derniermembre.'</a>.</p>';
$query->CloseCursor();
?>
</div>