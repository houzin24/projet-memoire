<?php
    $requete = $bdd->query('SELECT * FROM annees ORDER BY id DESC');
    $donnee = $requete->fetch();

    if($donnee){
        $affiche = 'Gestion Des Ecoles '.$donnee['debut'].' '.$donnee['fin'];
    }else{
        $affiche = 'Gestion Des Ecoles';
    }
?>

<h3 class="text-center" style="color: #777"><?php echo $affiche; ?></h3>