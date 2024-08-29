<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){ //1
    
    $niveau = htmlspecialchars($_POST['niveau']);
    $matiere = htmlspecialchars($_POST['matiere']);
    
    if(trim($_POST['description'])){
        $description = htmlspecialchars($_POST['description']);
    } else{
        $erreur1 = "oui";
    }
    
    $requete = $bdd->query('SELECT * FROM annees ORDER BY id DESC');
    $donnee = $requete->fetch();

    if($donnee){
        $annee = $donnee['debut'].' - '.$donnee['fin'];
    }else{
        $erreur2 = "oui";
    }
    
    
    if(isset($description) AND isset($annee)){
        $requete = $bdd->prepare('INSERT INTO cahier_test VALUE(null, ?, ?, ?, ?, ?, NOW())');
        $requete->execute(array($matiere, $niveau, $_SESSION['GEid'], $description, $annee));
        header('location: cahier.php');
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
                    <li><a href="cahier">Cahier de test</a></li>
                    <li class="active">Ajouter dans cahier de test</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 col-md-offset-4 alert" style="border: 1px solid #ccc">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur2)){echo 'has-error';} ?>">
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
                        
                        <?php
                        if(isset($erreur2)){
                        ?>
                        <span class="help-block">Année scolaire vide, veuillez contacter l'admin</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){echo 'has-error';} ?>">
                        <label class="control-label">Niveau</label>
                        <select class="form-control" name="matiere">
                            <?php
                            $requete = $bdd->query('SELECT * FROM matiere');
                            while($donnees = $requete->fetch()){
                            ?>
                            <option><?php echo $donnees['matiere']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur1)){echo 'has-error';} ?>">
                        <label class="control-label">Description</label>
                        <textarea rows="15" class="form-control" style="resize: none" name="description"></textarea>
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-primary" name="valider">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.cahier').removeClass('no');
                $('.cahier').addClass('select');
            });
        </script>
    </body>
</html>