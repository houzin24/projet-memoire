<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    $sexe = htmlspecialchars($_POST['sexe']);
    
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
    
    if(trim($_POST['nationalite'])){
        $nationalite = htmlspecialchars($_POST['nationalite']);
    } else{
        $erreur3 = "oui";
    }
    
    if(trim($_POST['tel'])){

        if(is_numeric($_POST['tel'])){
            $tel = htmlspecialchars($_POST['tel']);
        } else{
            $erreur5 = "oui";
        }

    } else{
        $erreur4 = "oui";
    }
    
    if(trim($_POST['mail'])){
        $mail = htmlspecialchars($_POST['mail']);
    } else{
        $erreur6 = "oui";
    }
    
    if(trim($_POST['adresse'])){
        $adresse = htmlspecialchars($_POST['adresse']);
    } else{
        $erreur7 = "oui";
    }
    
    
    if(isset($nom) AND isset($prenom) AND isset($nationalite) AND isset($tel) AND isset($mail) AND isset($adresse)){ //2
        $requete = $bdd->prepare('INSERT INTO professeur VALUE(null, UCASE(?), ?, ?, ?, ?, ?, ?, "non")');
        $requete->execute(array($nom, $prenom, $sexe, $nationalite, $tel, $mail, $adresse));
        header('location: professeur.php');
    } //Fin 2
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout professeur / Gestion Ecole</title>
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
                    <li><a href="professeur.php">Professeur</a></li>
                    <li class="active">Ajouter professeur</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <form method="post">
                <div class="col">
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                            <label>Nom</label>
                            <input class="form-control" placeholder="Nom du professeur" name="nom" value="<?php if(isset($nom)){ echo $nom; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">    
                        <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?>">
                            <label>Prénom</label>
                            <input class="form-control" placeholder="Prénom du professeur" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; } ?>">
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
                            <label>Nationalité</label>
                            <input class="form-control" placeholder="Nationalité du professeur" name="nationalite" value="<?php if(isset($nationalite)){ echo $nationalite; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">    
                        <div class="form-group <?php if(isset($erreur4)){ echo 'has-error'; } ?><?php if(isset($erreur5)){ echo 'has-error'; } ?>">
                            <label>Téléphone</label>
                            <input class="form-control" placeholder="Numéro de téléphone" name="tel" value="<?php if(isset($tel)){ echo $tel; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">    
                        <div class="form-group <?php if(isset($erreur6)){ echo 'has-error'; } ?>">
                            <label>Email</label>
                            <input class="form-control" placeholder="Email du professeur" name="mail" value="<?php if(isset($mail)){ echo $mail; } ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group <?php if(isset($erreur7)){ echo 'has-error'; } ?>">
                            <label>Adresse</label>
                            <input class="form-control" placeholder="Adresse du professeur" name="adresse" value="<?php if(isset($adresse)){ echo $adresse; } ?>">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-top: 20px">
                    <button class="btn btn-success btn-sm" name="valider">Enregistrer</button>
                </div>
            </form>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.professeur').removeClass('no');
                $('.professeur').addClass('select');
            });
        </script>
    </body>
</html>