<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){
    
    $demande = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = ? AND id_heure = ?');
    $demande->execute(array(
        $_GET['niveau'],
        $_POST['jour'],
        $_POST['heure']));
    $reponse = $demande->fetch();
    
    if($reponse){
        $erreur1 = "oui";
    } else{
        $requete = $bdd->prepare('INSERT INTO seance VALUE(null, ?, ?, ?, ?)');
        $requete->execute(array($_GET['niveau'], $_POST['matiere'],  $_POST['jour'], $_POST['heure']));
        header('location: emploi_du_temps.php?niveau='.$_GET['niveau']);
    }
    
    
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Emploi du temps / Gestion Ecole</title>
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
                    <li><a href="emploi_du_temps.php">Emploi du temps</a></li>
                    <li class="active">Ajouter de séance</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group">
                        <?php
                        $requete = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
                        $requete -> execute(array($_GET['niveau']));
                        $niveau = $requete->fetch();
                        ?>
                        <legend class="text-center"><b>Niveau: </b><?php echo $niveau['niveau'].' '.$niveau['filiere'].' '.$niveau['annee'] ?></legend>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Matière</label>
                        <select class="form-control" name="matiere">
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM matiere WHERE niveau = ?');
                            $requete -> execute(array($_GET['niveau']));
                            while($donnees = $requete->fetch()){
                            ?>
                            <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['matiere'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Jour</label>
                        <select class="form-control" name="jour">
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Lundi')){echo 'selected';} ?>>Lundi</option>
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Mardi')){echo 'selected';} ?>>Mardi</option>
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Mercredi')){echo 'selected';} ?>>Mercredi</option>
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Jeudi')){echo 'selected';} ?>>Jeudi</option>
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Vendredi')){echo 'selected';} ?>>Vendredi</option>
                            <option <?php if(isset($_POST['jour']) AND ($_POST['jour'] == 'Samedi')){echo 'selected';} ?>>Samedi</option>
                        </select>
                        
                        <?php
                        if(isset($erreur1)){
                        ?>
                        <span class="help-block">Jour et heure déjà programmé</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Heure</label>
                        <select class="form-control" name="heure">
                            <?php
                            $requete = $bdd->query('SELECT * FROM heure');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option <?php if(isset($_POST['heure']) AND ($_POST['heure'] == $donnees['id'])){echo 'selected';} ?> value="<?php echo $donnees['id'] ?>"><?php echo $donnees['heure']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
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
                $('.emploi').removeClass('no');
                $('.emploi').addClass('select');
            });
        </script>
    </body>
</html>