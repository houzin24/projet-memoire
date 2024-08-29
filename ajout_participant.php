<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(empty($_GET['id'])){
    header('location: activite.php');
}

if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['activite'])){
        $activite = htmlspecialchars($_POST['activite']);
    } else{
        $erreur1 = "oui";
    }
    
    if(isset($activite)){
        $requete = $bdd->prepare('INSERT INTO participant VALUE(null, ?, ?)');
        $requete->execute(array($activite, $_GET['id']));
        header('location: activite.php');
    }
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ajout participant / Gestion Ecole</title>
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
                    <li class="active">Ajouter participant</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group">
                        <label class="control-label">Etudiant</label>
                        <select class="form-control" name="activite">
                            <?php
                            $requete = $bdd->query('SELECT * FROM etudiants');
                            while($donnees = $requete->fetch()){
                                
                                $requete1 = $bdd->prepare('SELECT * FROM participant WHERE id_activite = ? AND id_etudiant = ?');
                                $requete1->execute(array($_GET['id'], $donnees['id']));
                                $donnees1 = $requete1->fetch();
                                
                                if($donnees1){
                                } else{
                            ?>
                            <option value="<?php echo $donnees['id'] ?>">
                                <?php echo $donnees['nom'].' '.$donnees['prenom']; ?>
                            </option>
                            <?php
                                }
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
                $('.activite').removeClass('no');
                $('.activite').addClass('select');
            });
        </script>
    </body>
</html>