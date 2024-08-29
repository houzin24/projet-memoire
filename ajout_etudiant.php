<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    $sexe = htmlspecialchars($_POST['sexe']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $type_parent = htmlspecialchars($_POST['type_parent']);
    $annee = htmlspecialchars($_POST['annee']);
    
    if(trim($_POST['nom'])){
        $nom = htmlspecialchars($_POST['nom']);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['prenom'])){
        $prenom = htmlspecialchars($_POST['prenom']);
    } else{
        $erreur2 = "oui";
    }
    
    if(trim($_POST['naissance'])){
        $naissance = $_POST['naissance'];
        
        $naissance1 = explode('/', $naissance);
        $naissance1 = array_reverse($naissance1);
        $naissance1 = implode('-', $naissance1);
    } else{
        $erreur3 = "oui";
    }
    
    
    
    if(trim($_POST['nationalite'])){
        $nationalite = htmlspecialchars($_POST['nationalite']);
    } else{
        $erreur5 = "oui";
    }
    
    if(trim($_POST['tel'])){

        if(is_numeric($_POST['tel'])){
            $tel = htmlspecialchars($_POST['tel']);
        } else{
            $erreur7 = "oui";
        }

    } else{
        $erreur6 = "oui";
    }
    
    if(trim($_POST['adresse'])){
        $adresse = htmlspecialchars($_POST['adresse']);
    } else{
        $erreur8 = "oui";
    }
    
    if(trim($_POST['nom_parent'])){
        $nom_parent = htmlspecialchars($_POST['nom_parent']);
    } else{
        $erreur9 = "oui";
    }
    
    if(trim($_POST['prenom_parent'])){
        $prenom_parent = htmlspecialchars($_POST['prenom_parent']);
    } else{
        $erreur10 = "oui";
    }
    
    if(trim($_POST['contact_parent'])){

        if(is_numeric($_POST['contact_parent'])){
            $contact_parent = htmlspecialchars($_POST['contact_parent']);
        } else{
            $erreur12 = "oui";
        }

    } else{
        $erreur11 = "oui";
    }
    
    
    
    if(isset($nom) AND isset($prenom) AND isset($sexe) AND isset($naissance) AND isset($nationalite) AND isset($tel) AND isset($adresse) AND isset($niveau) AND isset($annee) AND isset($nom_parent) AND isset($prenom_parent) AND isset($contact_parent)){ //2
        
        $requete = $bdd->prepare('INSERT INTO etudiants VALUES(null, ?, ?, ?, ?, ?, ?, ?, ?, "", ?)');
        $requete->execute(array(
            $nom,
            $prenom,
            $sexe,
            $naissance,
            $nationalite,
            $tel,
            $niveau,
            $adresse,
            $annee));
        
        $requete = $bdd->prepare('SELECT id FROM etudiants WHERE nom = ? AND prenom = ?');
        $requete->execute(array($nom, $prenom));
        $donnee = $requete->fetch();
        
        $id = $donnee['id'];
        
        $requete = $bdd->prepare('INSERT INTO parent VALUES(null, ?, ?, ?, ?, ?)');
        $requete->execute(array(
            $nom_parent,
            $prenom_parent,
            $type_parent,
            $id,
            $contact_parent));
        
        $requete1 = $bdd->prepare('SELECT tarif FROM niveau WHERE id = ?');
        $requete1->execute(array($niveau));
        $donnee1 = $requete1->fetch();
        
        $tarif = $donnee1['tarif'];
        
        $requete2 = $bdd->prepare('UPDATE etudiants SET frais_formation = ? WHERE id = ?');
        $requete2->execute(array($tarif, $id));
        
        header('location: etudiant.php');
        
    } //Fin 2
    
    
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout étudiant / Gestion Ecole</title>
        <?php include("head.php"); ?>
    </head>
    
    <body>
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li><a href="etudiant.php">Etudiants</a></li>
                    <li class="active">Ajouter étudiant</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <form method="post">
                <div class="col">
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                            <label>Nom</label>
                            <input class="form-control" placeholder="Nom de l'étudiant" name="nom" value="<?php if(isset($nom)){ echo $nom; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">    
                        <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?>">
                            <label>Prénom</label>
                            <input class="form-control" placeholder="Prénom de l'étudiant" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sexe</label>
                            <select class="form-control" name="sexe">
                                <option value="masculin">Masculin</option>
                                <option value="feminin">Féminin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                            <label>Naissance</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control" placeholder="Date de naissance" name="naissance" value="<?php if(isset($naissance)){ echo $naissance; } ?>">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur5)){ echo 'has-error'; } ?>">
                            <label>Nationalité</label>
                            <input class="form-control" placeholder="Nationalité de l'étudiant" name="nationalite" value="<?php if(isset($nationalite)){ echo $nationalite; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">    
                        <div class="form-group <?php if(isset($erreur6)){ echo 'has-error'; } ?><?php if(isset($erreur7)){ echo 'has-error'; } ?>">
                            <label>Téléphone</label>
                            <input class="form-control" placeholder="Numéro de téléphone" name="tel" value="<?php if(isset($tel)){ echo $tel; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur8)){ echo 'has-error'; } ?>">
                            <label>Adresse</label>
                            <input class="form-control" placeholder="Adresse de l'étudiant" name="adresse" value="<?php if(isset($adresse)){ echo $adresse; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Affectation</label>
                            <select class="form-control" name="niveau">
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Année scolaire</label>
                            <?php
                            $requete = $bdd->query('SELECT * FROM annees ORDER BY id DESC');
                            $donnees = $requete->fetch();
                            ?>
                            <input class="form-control" value="<?php echo $donnees['debut'].' - '.$donnees['fin']; ?>" disabled>
                            <input type="hidden" value="<?php echo $donnees['debut'].' - '.$donnees['fin']; ?>" name="annee">
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-12" style="margin-top: 60px; padding-left: 0">
                    <legend style="padding-left: 15px">Parent</legend>
                </div>
                
                <div class="col">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type_parent">
                                <option>Père</option>
                                <option>Mère</option>
                                <option>Tuteur</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur9)){ echo 'has-error'; } ?>">
                            <label>Nom</label>
                            <input class="form-control" placeholder="Nom" name="nom_parent" value="<?php if(isset($nom_parent)){ echo $nom_parent; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur10)){ echo 'has-error'; } ?>">
                            <label>Prénom</label>
                            <input class="form-control" placeholder="Prénom" name="prenom_parent" value="<?php if(isset($prenom_parent)){ echo $prenom_parent; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur11)){ echo 'has-error'; } ?><?php if(isset($erreur12)){ echo 'has-error'; } ?>">
                            <label>Contact</label>
                            <input class="form-control" placeholder="Numéro de contact" name="contact_parent" value="<?php if(isset($contact_parent)){ echo $contact_parent; } ?>">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-top: 20px">
                    <button class="btn btn-success btn-sm pull-right" name="valider">Enregistrer les informations de l'étudiant</button>
                </div>
            </form>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.etudiant').removeClass('no');
                $('.etudiant').addClass('select');
            });
        </script>
    </body>
</html>