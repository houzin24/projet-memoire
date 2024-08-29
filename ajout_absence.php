<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    $etudiant = htmlspecialchars($_POST['etudiant']);
    $jour = htmlspecialchars($_POST['jour']);
    $heure = htmlspecialchars($_POST['heure']);
    $user = $_SESSION['GEnom'].' '.$_SESSION['GEprenom'];
    
    if(isset($etudiant) AND isset($jour) AND isset($heure)){
        $requete = $bdd->prepare('INSERT INTO absence VALUE(null, ?, ?, ?, NOW(), ?)');
        $requete->execute(array($etudiant, $jour, $heure, $user));
        header('location: absence.php');
    }
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout absence / Gestion Ecole</title>
        
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
                    <li><a href="absence.php">Absence</a></li>
                    <li class="active">Ajouter une absence</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group">
                        <label class="control-label">Etudiant</label>
                        <select class="form-control" name="etudiant">
                            <?php
                            $requete = $bdd->query('SELECT * FROM etudiants');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['nom'].' '.$donnees['prenom']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Jour</label>
                        <select class="form-control" name="jour">
                            <option>Lundi</option>
                            <option>Mardi</option>
                            <option>Mercredi</option>
                            <option>Jeudi</option>
                            <option>Vendredi</option>
                            <option>Samedi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Heure</label>
                        <select class="form-control" name="heure">
                            <?php
                            $requete = $bdd->query('SELECT * FROM heure');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['heure']; ?></option>
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
                $('.absence').removeClass('no');
                $('.absence').addClass('select');
            });
        </script>
    </body>
</html>