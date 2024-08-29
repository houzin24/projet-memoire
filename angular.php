<?php
include("session.php");
include("connexionBDD.php");

$req=$bdd->query('SELECT * FROM etudiants ORDER BY id DESC');
if(FALSE == ($reponse = $req->fetch())){
} else{

    $table = array();

    do{
        $requete = $bdd->prepare('SELECT * FROM parent WHERE id_etudiant = ?');
        $requete->execute(array($reponse['id']));
        $donnees = $requete->fetch();

        $requete1 = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
        $requete1->execute(array($reponse['niveau']));
        $donnees1 = $requete1->fetch();

        if($donnees){
            $parent = $donnees['type'].': '.$donnees['nom'].' '.$donnees['prenom'].' | '.$donnees['tel'];
        } else{
            $parent = "";
        }

        $table[] = array(
            'id' => $reponse['id'],
            'nom' => $reponse['nom'],
            'prenom' => $reponse['prenom'],
            'sexe' => $reponse['sexe'],
            'naissance' => $reponse['naissance'],
            'nationalite' => $reponse['nationalite'],
            'tel' => $reponse['tel'],
            'adresse' => $reponse['adresse'],
            'niveau' => $donnees1['niveau'].' '.$donnees1['filiere'].' '.$donnees1['annee'],
            'parent' => $parent,
            'frais_formation' => $reponse['frais_formation'],
            'annee_scolaire' => $reponse['annee_scolaire'],
        );

    }while($reponse = $req->fetch());

    echo json_encode($table);
}
?>