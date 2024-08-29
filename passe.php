<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['success'])){
    $success = "oui";
}

if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['passe1'])){
        $passe1 = htmlspecialchars($_POST['passe1']);
        $passe11 = sha1($passe1);
    } else {
        $erreur1 = "oui";
        unset($success);
    }
    
    if(trim($_POST['passe2'])){
        $passe2 = htmlspecialchars($_POST['passe2']);
        $passe22 = sha1($passe2);
    } else {
        $erreur2 = "oui";
        unset($success);
    }
    
    
    if(isset($passe11) AND isset($passe22)){
        
        if($_SESSION['GEtype'] == 'Admin'){ //2
            
            $req=$bdd->prepare('SELECT passe FROM users WHERE id = ?');
            $req->execute(array($_SESSION['GEid']));
            $reponse=$req->fetch();

            if($reponse['passe'] == $passe11){

                $reponse = $bdd->prepare ('UPDATE users SET passe = ? WHERE id = ?');
                $reponse->execute(array(
                $passe22,
                $_SESSION['GEid']));

                header('location: passe.php?success');
            } else {
                $erreur3 = "oui";
                unset($success);
            }
            
        } //Fin 2
        
        
        
        if($_SESSION['GEtype'] == 'Professeur'){ //3
            
            $req=$bdd->prepare('SELECT passe FROM professeur WHERE id = ?');
            $req->execute(array($_SESSION['GEid']));
            $reponse=$req->fetch();

            if($reponse['passe'] == $passe11){

                $reponse = $bdd->prepare ('UPDATE professeur SET passe = ? WHERE id = ?');
                $reponse->execute(array(
                $passe22,
                $_SESSION['GEid']));

                header('location: passe.php?success');
            } else {
                $erreur3 = "oui";
                unset($success);
            }
            
        } //Fin 3
        
        
    }
    
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
                    <li class="active">Modifier mot de passe</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?><?php if(isset($success)){ echo 'has-success'; } ?><?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Ancien mot de passe</label>
                        <input type="password" class="form-control" placeholder="**************" name="passe1" autofocus>
                        <?php
                        if(isset($success) AND ($success == "oui")){
                        ?>
                        <span class="help-block">Modification éffectuée avec succès</span>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if(isset($erreur3) AND ($erreur3 == "oui")){
                        ?>
                        <span class="help-block">Mot de passe non identique</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?><?php if(isset($success)){ echo 'has-success'; } ?>">
                        <label class="control-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" placeholder="**************" name="passe2">
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-success" name="valider">Modifier</button>
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