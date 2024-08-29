<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    
    if(trim($_POST['nom'])){
        $nom = htmlspecialchars($_POST['nom']);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['num'])){

        if(is_numeric($_POST['num'])){
            $num = htmlspecialchars($_POST['num']);
        } else{
            $erreur3 = "oui";
        }

    } else{
        $erreur2 = "oui";
    }
    
    if(trim($_POST['type'])){
        $type = htmlspecialchars($_POST['type']);
    } else{
        $erreur4 = "oui";
    }
    
    
    if(isset($nom) AND isset($num) AND isset($type)){ //2
        $requete = $bdd->prepare('INSERT INTO salle VALUE(null, ?, ?, ?)');
        $requete->execute(array($nom, $num, $type));
        header('location: salle.php');
    } //Fin 2
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout salle / Gestion Ecole</title>
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
                    <li><a href="salle.php">Salle</a></li>
                    <li class="active">Ajouter une salle</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Nom</label>
                        <input class="form-control" placeholder="Nom de la salle" name="nom" value="<?php if(isset($nom)){ echo $nom; } ?>" autofocus>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?><?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Numéro</label>
                        <input class="form-control" name="num" value="<?php if(isset($num)){ echo $num; } ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur4)){ echo 'has-error'; } ?>">
                        <label class="control-label">type de salle</label>
                        <input class="form-control" placeholder="Type de salle" name="type" value="<?php if(isset($type)){ echo $type; } ?>">
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
                $('.salle').removeClass('no');
                $('.salle').addClass('select');
            });
        </script>
    </body>
</html>