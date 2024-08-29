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
    
    if(trim($_POST['nom'])){
        $nom = $_POST['nom'];
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['prenom'])){
        $prenom = $_POST['prenom'];
    } else{
        $erreur2 = "oui";
    }
    
    if(trim($_POST['email'])){
        $email = $_POST['email'];
    } else{
        $erreur3 = "oui";
    }
    
    if(isset($nom) AND isset($prenom) AND isset($email)){
        
        if($_SESSION['GEtype'] == 'Admin'){
            $requete = $bdd->prepare('UPDATE users SET nom = ?, prenom = ?, mail = ? WHERE id = ?');
            $requete->execute(array($nom, $prenom, $email, $_SESSION['GEid']));
            
            $_SESSION['GEnom'] = $nom;
            $_SESSION['GEprenom'] = $prenom;
            
            header('location: compte.php?success');
        }
        
        if($_SESSION['GEtype'] == 'Professeur'){
            $requete = $bdd->prepare('UPDATE professeur SET nom = ?, prenom = ?, mail = ? WHERE id = ?');
            $requete->execute(array($nom, $prenom, $email, $_SESSION['GEid']));
            
            $_SESSION['GEnom'] = $nom;
            $_SESSION['GEprenom'] = $prenom;
            
            header('location: compte.php?success');
        }
        
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
                    <li class="active">Compte</li>
                    <li><a href="passe.php">Modifier mot de passe</a></li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-3 alert">
                <?php
                if($_SESSION['GEtype'] == 'Admin'){
                ?>

                <div class="panel panel-info">
                     <ul class="list-group">
                        <a href="liste_admin.php" class="list-group-item">Liste des admin</a>
                        <a href="ajout_admin.php" class="list-group-item">Ajouter un admin</a>
                    </ul>
                </div>

                <?php
                }
                ?>
            </div>
            
            <div class="col-md-4 col-md-offset-1 alert" style="border: 1px solid #ccc; margin-top: 15px">
                
                <?php
                $requete = $bdd->prepare('SELECT * FROM users WHERE nom = ?');
                $requete -> execute(array($_SESSION['GEnom']));
                $reponse = $requete->fetch();
                
                if($reponse){
                }else{
                    $requete = $bdd->prepare('SELECT * FROM professeur WHERE nom = ?');
                    $requete -> execute(array($_SESSION['GEnom']));
                    $reponse = $requete->fetch();
                }
                
                ?>
                
                <form method="post">
                    <div class="form-group <?php if(isset($erreur1)){ echo 'has-error'; } ?><?php if(isset($success)){ echo 'has-success'; } ?>">
                        <label class="control-label">Nom</label>
                        <input class="form-control" placeholder="Votre nom" name="nom" value="<?php echo $reponse['nom']; ?>">
                        <?php
                        if(isset($success) AND ($success == "oui")){
                        ?>
                        <span class="help-block">Modification éffectuée avec succès</span>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur2)){ echo 'has-error'; } ?><?php if(isset($success)){ echo 'has-success'; } ?>">
                        <label class="control-label">Prénom</label>
                        <input class="form-control" placeholder="Votre prenom" name="prenom" value="<?php echo $reponse['prenom']; ?>">
                    </div>
                    
                    <div class="form-group <?php if(isset($erreur3)){ echo 'has-error'; } ?><?php if(isset($success)){ echo 'has-success'; } ?>">
                        <label class="control-label">Email</label>
                        <input class="form-control" placeholder="Votre email" name="email" value="<?php echo $reponse['mail']; ?>">
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