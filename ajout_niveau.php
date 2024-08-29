<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['niveau'])){
        $niveau = htmlspecialchars($_POST['niveau']);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['annee'])){
        $annee = htmlspecialchars($_POST['annee']);
    } else{
        $erreur2 = "oui";
    }
    
    if(trim($_POST['filiere'])){
        $filiere = htmlspecialchars($_POST['filiere']);
    } else{
        $erreur3 = "oui";
    }
    
    if(trim($_POST['tarif'])){

        if(is_numeric($_POST['tarif'])){
            $tarif = htmlspecialchars($_POST['tarif']);
        } else{
            $erreur5 = "oui";
        }

    } else{
        $erreur4 = "oui";
    }
    
    
    if(isset($niveau) AND isset($annee) AND isset($filiere) AND isset($tarif)){
        $requete = $bdd->prepare('INSERT INTO niveau VALUE(null,UPPER(?) , ?, ?, ?)');
        $requete->execute(array($niveau, $annee, $filiere, $tarif));
        header('location: niveau.php');
    }
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout niveau / Gestion Ecole</title>
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
                    <li><a href="niveau.php">Niveau</a></li>
                    <li class="active">Ajouter niveau</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Niveau</label>
                        <input class="form-control" placeholder="Niveau" name="niveau" value="<?php if(isset($niveau)){ echo $niveau; } ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?>">
                        <label class="control-label">Année</label>
                        <div class="input-group">
                            <input class="form-control" name="annee" value="<?php if(isset($annee)){ echo $annee; } ?>">
                            <div class="input-group-addon">
                                Année
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur3)){ echo 'has-error'; } ?>">
                        <label class="control-label">Filière</label>
                        <input class="form-control" placeholder="Filière" name="filiere" value="<?php if(isset($filiere)){ echo $filiere; } ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur4)){ echo 'has-error'; } ?><?php if(isset($erreur5)){ echo 'has-error'; } ?>">
                        <label class="control-label">Tarif</label>
                        <div class="input-group">
                            <input class="form-control" placeholder="Frais de formation" name="tarif" value="<?php if(isset($tarif)){ echo $tarif; } ?>">
                            <div class="input-group-addon">
                                F CFA
                            </div>
                        </div>
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
                $('.niveau').removeClass('no');
                $('.niveau').addClass('select');
            });
        </script>
    </body>
</html>