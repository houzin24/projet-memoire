<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    
    if(trim($_POST['passe1'])){
        $passe1 = htmlspecialchars($_POST['passe1']);
        $passe11 = sha1($passe1);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['passe2'])){
        $passe2 = htmlspecialchars($_POST['passe2']);
        $passe22 = sha1($passe2);
    } else{
        $erreur2 = "oui";
    }
    
    
    
    
    if(isset($passe11) AND isset($passe22)){ //2
        
        if($passe11 == $passe22){
            
            $requete = $bdd->prepare('UPDATE professeur SET passe = ? WHERE id = ?');
            $requete->execute(array($passe22, $_GET['id']));
            header('location: professeur.php');
            
        } else{
            $erreur3 = "oui";
        }
        
        
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
                    <li class="active">Ajouter mot de passe</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group">
                        <label class="control-label">Nom</label>
                        <input class="form-control" disabled value="<?php echo $_GET['nom'].' '.$_GET['prenom'] ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?><?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Mot de passe</label>
                        <input class="form-control" type="password" placeholder="***********" name="passe1" autofocus>
                        <?php
                        if(isset($erreur3) AND ($erreur3 == "oui")){
                        ?>
                        <span class="help-block">Mot de passe non identique</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?><?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Confirmer mot de passe</label>
                        <input class="form-control" type="password" placeholder="***********" name="passe2">
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-sm btn-primary" name="valider">Enregistrer</button>
                    </div>
                </form>
            </div>
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