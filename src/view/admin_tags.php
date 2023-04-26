 <?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Controller\Tag;

$Tag=new Tag;
$tags=$Tag->getAllPreview();

echo '<div id="BoxButton" onclick=""><button id="AddButton">Ajouter un tags</button></div>';
echo '<table class="TBAffichage">';
echo '<tr class="Desc"><td><b>Nom : </b></td><td><b>Description : </b></td><td colspan="3"><b>Commandes </b></td></tr>';


foreach ($tags as $tag) {


    echo '<tr>';
    echo '<td>';
    echo $tag['name'];
    echo '</td>';

    echo '<td class="description">';
    echo $tag['preview']." ...";
    echo '</td>';
    echo '<td><button>Renommer</button></td>';
    echo '<td><button>Changer description</button></td>';
    echo '<td><button class="Supprimer">Supprimer le tag</button></td> </tr>';

}
echo "</table>";
?>