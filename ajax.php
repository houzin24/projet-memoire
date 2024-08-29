<?php
include("connexionBDD.php");

if(isset($_POST['users'])){
    
    $users = $_POST['users'];
    
    if(strlen($users) > 0){
        $reponse = $bdd->query("SELECT id, nom, prenom FROM etudiants WHERE nom LIKE '$users%' OR prenom LIKE'$users%' LIMIT 5");
        
        if(FALSE == ($donnees = $reponse->fetch())){
            echo '<a class="list-group-item" style="width: 300px; border-color: #bbb; background-color:#ddd; margin-top: 2px">Aucun résultat</a>';
            } else {
                do{
                    echo '<a href="select.php?id='.$donnees['id'].' " class="list-group-item" style="padding: 5px; width: 300px; border-color: #bbb; background-color:#ddd; margin-top: 2px">'.$donnees['nom'].' '.$donnees['prenom'].'</a>';
                }while($donnees = $reponse->fetch());
        }
    }
    
}
?>
