<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    $niveau = htmlspecialchars($_POST['niveau']);
    $prof = htmlspecialchars($_POST['prof']);
    
    if(trim($_POST['matiere'])){
        $matiere = htmlspecialchars($_POST['matiere']);
    } else{
        $erreur1 = "oui";
    }
    
    if(isset($matiere)){
        $requete = $bdd->prepare('INSERT INTO matiere VALUE(null, UCASE(?), ?, ?)');
        $requete->execute(array($matiere, $niveau, $prof));
        header('location: matiere.php');
    }
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout matière / Gestion Ecole</title>
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
                    <li><a href="matiere.php">Matière</a></li>
                    <li class="active">Ajouter matière</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="control-label">Matière</label>
                        <input class="form-control" placeholder="Matière" name="matiere" autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Niveau</label>
                        <select class="form-control" name="niveau">
                            <?php
                            $requete = $bdd->query('SELECT * FROM niveau');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Professeur</label>
                        <select class="form-control" name="prof">
                            <?php
                            $requete = $bdd->query('SELECT * FROM professeur');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option value="<?php echo $donnees['id'] ?>"><?php echo $donnees['nom'].' '.$donnees['prenom']; ?></option>
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
                $('.matiere').removeClass('no');
                $('.matiere').addClass('select');
            });
        </script>
    </body>
</html>