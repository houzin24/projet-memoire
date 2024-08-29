<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_POST['valider'])){
    
    $payer = htmlspecialchars($_POST['payer']);
    $frais = htmlspecialchars($_POST['frais']);
    
    if(is_numeric($payer)){
        
        $reste = $frais - $payer;
        
        if($reste < 0){
            $reste = 0;
        }
        
        $requete = $bdd->prepare('UPDATE etudiants SET frais_formation = ? WHERE id = ?');
        $requete->execute(array($reste, $_GET['id']));
        header('location: payement.php');
        
    } else{
        $erreur1 = "oui";
    }
    
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Payement / Gestion Ecole</title>
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
                    <li><a href="payement.php">Payement</a></li>
                    <li class="active">Etudiant Sélectionné</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-6">
                <div class="col-md-4">
                    <i class="fa fa-user" style="font-size: 200px"></i>
                </div>
                
                <div class="col-md-8" style="padding-top: 10px">
                    
                    <?php
                    $requete = $bdd->prepare('SELECT * FROM etudiants WHERE id = ?');
                    $requete->execute(array($_GET['id']));
                    $donnees = $requete->fetch();
                    
                    $requete1 = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
                    $requete1->execute(array($donnees['niveau']));
                    $donnees1 = $requete1->fetch();
                    ?>
                    
                    <p>
                        <span style="font-size: 25px">Nom:</span>
                        <span style="font-size: 25px" class="text-primary"><?php echo $donnees['nom']; ?></span>
                    </p>
                    
                    <p>
                        <span style="font-size: 25px">Prénom:</span>
                        <span style="font-size: 25px" class="text-primary"><?php echo $donnees['prenom']; ?></span>
                    </p>
                    
                    <p>
                        <span style="font-size: 25px">Niveau:</span>
                        <span style="font-size: 25px" class="text-primary">
                            <?php echo $donnees1['niveau'].' '.$donnees1['filiere'].' '.$donnees1['annee']; ?>
                        </span>
                    </p>
                    
                    <p>
                        <span style="font-size: 25px">Reste à payer:</span>
                        <span style="font-size: 25px" class="text-danger">
                            <?php echo $donnees['frais_formation']; ?>
                        </span>
                    </p>
                </div>
            </div>
            
            <?php
            if($donnees['frais_formation'] != 0){
            ?>
            <div class="col-md-4" style="border: 1px solid #ccc; padding-top: 40px; padding-bottom: 40px; border-radius: 4px">
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?>">
                        <label class="label-control">Effectuer un payement</label>
                        <div class="input-group">
                            <input class="form-control" placeholder="Somme à payer" name="payer" autofocus>
                            <div class="input-group-addon">
                                F CFA
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $donnees['frais_formation']; ?>" name="frais">
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-info" name="valider">Valider</button>
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
            
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.payement').removeClass('no');
                $('.payement').addClass('select');
            });
        </script>
    </body>
</html>