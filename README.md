Doard
=====

Board PHP simple adaptable sous bootstrap, suivit d'un tutoriel du SiteDuZéro.<br />
La version distribuée est une version de test pour le Github Aidemu, le code est simple, non simplifé, et un peu en vrac.<br />
Vous pouvez réutiliser ces scripts, ils proviennent du SiteDuZéro; je les ai seulement adapté à Bootstrap.<br />

Installation
=====

1) Téléchargez Doard.<br />
2) Dézippez Doard dans le dossier "www" de wamp ou "htdocs" de xampp.<br />
3) Editez le fichier "identifiants.php", et modifiez la ligne suivante comme ceci :<br />
    $db = new PDO('mysql:host=IP_BDD;dbname=DB_NAME', 'USER', 'PASS');<br />
4) Exécutez le fichier "SQL_Doard.sql" sur votre base de données.
    
Utilisation
=====

Aucun panel d'administration n'est encore développé, vous devez tout faire à la main via votre base de données !
