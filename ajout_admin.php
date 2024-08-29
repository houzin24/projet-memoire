<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php

if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['nom'])){
        $nom = $_POST['nom'];
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['prenom'])){
        $prenom = $_POST['prenom'];
    } else{
        $erreur2 = "oui";
    }
    
    if(trim($_POST['email'])){
        $email = $_POST['email'];
    } else{
        $erreur3 = "oui";
    }
    
    if(trim($_POST['passe1'])){
        $passe1 = htmlspecialchars($_POST['passe1']);
        $passe11 = sha1($passe1);
    } else {
        $erreur4 = "oui";
    }
    
    if(trim($_POST['passe2'])){
        $passe2 = htmlspecialchars($_POST['passe2']);
        $passe22 = sha1($passe2);
    } else {
        $erreur5 = "oui";
    }
    
    if(isset($nom) AND isset($prenom) AND isset($email) AND isset($passe11) AND isset($passe22)){ //2
        
        if($passe11 == $passe22){ //3
            
            $requete = $bdd->prepare('INSERT INTO users VALUE(null, ?, ?, ?, ?, "Admin")');
            $requete->execute(array($nom, $prenom,  $email, $passe11));
            header('location: liste_admin.php');
            
        } else{
            $erreur6 = "oui";
        } //Fin 3
        
        
    } //Fin 2
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Compte / Gestion Ecole</title>
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
                    <li><a href="compte.php">Compte</a></li>
                    <li class="active">Ajouter un admin</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-3 alert">
                <?php
                if($_SESSION['GEtype'] == 'Admin'){
                ?>

                <div class="panel panel-info">
                     <ul class="list-group">
                        <a href="liste_admin.php" class="list-group-item">Liste des admin</a>
                        <a href="professeur.php" class="list-group-item active">Ajouter un admin</a>
                    </ul>
                </div>

                <?php
                }
                ?>
            </div>
            
            <div class="col-md-4 col-md-offset-1 alert" style="border: 1px solid #ccc; margin-top: 15px">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Nom</label>
                        <input class="form-control" placeholder="Nom" name="nom" value="<?php if(isset($nom)){echo $nom;} ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?>">
                        <label class="control-label">Prénom</label>
                        <input class="form-control" placeholder="Prenom" name="prenom" value="<?php if(isset($prenom)){echo $prenom;} ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Email</label>
                        <input class="form-control" placeholder="Email" name="email" value="<?php if(isset($email)){echo $email;} ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur4)){ echo 'has-error'; } ?><?php if(isset($erreur6)){ echo 'has-error'; } ?>">
                        <label class="control-label">Mot de passe</label>
                        <input class="form-control" type="password" placeholder="***********" name="passe1">
                        <?php
                        if(isset($erreur6)){
                        ?>
                        <span class="help-block">Mot de passe non identique</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur5)){ echo 'has-error'; } ?><?php if(isset($erreur6)){ echo 'has-error'; } ?>">
                        <label class="control-label">Confirmer mot de passe</label>
                        <input class="form-control" type="password" placeholder="***********" name="passe2">
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-sm" name="valider">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.compte').removeClass('no');
                $('.compte').addClass('select');
            });
        </script>
    </body>
</html>