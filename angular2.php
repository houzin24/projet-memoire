<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");

if($_SESSION['GEtype'] == 'Admin'){
    $req=$bdd->query('SELECT * FROM cahier_test ORDER BY id DESC');
    
} else {
    $req=$bdd->prepare('SELECT * FROM cahier_test WHERE prof = ? ORDER BY id DESC');
    $req ->execute(array($_SESSION['GEid']));
}


if(FALSE == ($reponse = $req->fetch())){
} else{

    $table = array();

    do{
        $requete = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
        $requete->execute(array($reponse['niveau']));
        $donnees = $requete->fetch();

        $requete1 = $bdd->prepare('SELECT * FROM professeur WHERE id = ?');
        $requete1->execute(array($reponse['prof']));
        $donnees1 = $requete1->fetch();

        $table[] = array(
            'id' => $reponse['id'],
            'matiere' => $reponse['matiere'],
            'niveau' => $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'],
            'prof' => $donnees1['nom'].' '.$donnees1['prenom'],
            'description' => $reponse['description'],
            'annee' => $reponse['annee'],
            'date' => $reponse['date'],
        );
    }while($reponse = $req->fetch());

    echo json_encode($table);
}
?>