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
    
    
    if(trim($_POST['profession'])){
        $profession = htmlspecialchars($_POST['profession']);
    } else{
        $erreur3 = "oui";
    }
    
    
    if(trim($_POST['num'])){

        if(is_numeric($_POST['num'])){
            $num = htmlspecialchars($_POST['num']);
        } else{
            $erreur5 = "oui";
        }

    } else{
        $erreur4 = "oui";
    }
    
    if(trim($_POST['adresse'])){
        $adresse = htmlspecialchars($_POST['adresse']);
    } else{
        $erreur6 = "oui";
    }
    
    
    if(isset($nom) AND isset($prenom) AND isset($profession) AND isset($num) AND isset($adresse)){ //2
        $requete = $bdd->prepare('INSERT INTO personnel VALUE(null, ?, ?, ?, ?, ?, ?)');
        $requete->execute(array($nom, $prenom, $sexe, $profession, $num, $adresse));
        header('location: personnel.php');
    } //Fin 2
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout de personnel / Gestion Ecole</title>
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
                    <li><a href="personnel.php">Personnel</a></li>
                    <li class="active">Ajouter un Personnel</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Nom</label>
                        <input class="form-control" placeholder="Nom" name="nom" value="<?php if(isset($nom)){ echo $nom; } ?>" autofocus>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?>">
                        <label class="control-label">Prénom</label>
                        <input class="form-control" placeholder="Prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; } ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Sexe</label>
                        <select class="form-control" name="sexe">
                            <option>Masculin</option>
                            <option>Féminin</option>
                        </select>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Profession</label>
                        <input class="form-control" placeholder="Profession" name="profession" value="<?php if(isset($profession)){ echo $profession; } ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur4)){ echo 'has-error'; } ?><?php if(isset($erreur5)){ echo 'has-error'; } ?>">
                        <label class="control-label">Téléphone</label>
                        <input class="form-control" placeholder="Téléphone" name="num" value="<?php if(isset($num)){ echo $num; } ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur6)){ echo 'has-error'; } ?>">
                        <label class="control-label">Adresse</label>
                        <input class="form-control" placeholder="Adresse" name="adresse" value="<?php if(isset($adresse)){ echo $adresse; } ?>">
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-success" name="valider">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.personnel').removeClass('no');
                $('.personnel').addClass('select');
            });
        </script>
    </body>
</html>