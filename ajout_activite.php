<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['activite'])){
        $activite = htmlspecialchars($_POST['activite']);
    } else{
        $erreur1 = "oui";
    }
    
    if(isset($activite)){
        $requete = $bdd->prepare('INSERT INTO activite VALUE(null, UCASE(?))');
        $requete->execute(array($activite));
        header('location: activite.php');
    }
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout activité / Gestion Ecole</title>
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
                    <li><a href="activite.php">Activité</a></li>
                    <li class="active">Ajouter activité</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Activité</label>
                        <input class="form-control" placeholder="Matière" name="activite" autofocus>
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
                $('.activite').removeClass('no');
                $('.activite').addClass('select');
            });
        </script>
    </body>
</html>