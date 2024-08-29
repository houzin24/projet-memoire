<?php
include("session.php");
session_unset();
?>

<?php
if(isset($_POST['valider'])){ //1
    
    if(trim($_POST['mail'])){
        $mail = htmlspecialchars($_POST['mail']);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['passe'])){
        $passe = htmlspecialchars($_POST['passe']);
        $passe1 = sha1($passe);
    } else{
        $erreur2 = "oui";
    }
    
    if(isset($mail) AND isset($passe1)){ //2
        include("connexionBDD.php");
        
        $reponse = $bdd->prepare ('SELECT * FROM users WHERE mail = ?  AND passe = ? ');
        $reponse->execute(array(
        $mail,
        $passe1));
        $donnees = $reponse->fetch();
        
        if($donnees){
            
            $_SESSION['GEid'] = $donnees['id'];
            $_SESSION['GEnom'] = $donnees['nom'];
            $_SESSION['GEprenom'] = $donnees['prenom'];
            $_SESSION['GEtype'] = $donnees['type'];

            header('location: accueil');
            exit;
        } else {
            
            $reponse = $bdd->prepare ('SELECT * FROM professeur WHERE mail = ?  AND passe = ? ');
            $reponse->execute(array(
            $mail,
            $passe1));
            $donnees1 = $reponse->fetch();
            
            if($donnees1){ //3
                
                $_SESSION['GEid'] = $donnees1['id'];
                $_SESSION['GEnom'] = $donnees1['nom'];
                $_SESSION['GEprenom'] = $donnees1['prenom'];
                $_SESSION['GEtype'] = 'Professeur';
                
                header('location: accueil');
                exit;
                
            }else{
                $erreur3 = "oui";
            } //Fin 3
            
        }
        
    } //Fin 2
    
} //Fin 1
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Authentification / Gestion Ecole</title>
        <link rel="shortcut icon" href="image/logoisi.png" type="image/png"/>
        <meta charset="utf-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <style>
            html, body{
                height: 100%;
            }

            body{
                display: table;
                width: 100%;
                background-color: #222d32;
            }
            
            .btn{
                background-color:#222d32;
                color: #999;
                border-color: #2c3b41
            }
            
            .btn:hover{
                color: white
            }
            
            .form-control, .form-control:focus{
                border-color: #2c3b41;
                -webkit-box-shadow: none;
                box-shadow: none;
            }
            
            .has-error .form-control, .has-error .form-control:focus{
                -webkit-box-shadow: none;
                box-shadow: none;
            }
        </style>
    </head>
    
    <body>
        <div class="col" style="background-color: #2c3b41; height: 250px; display: flex; flex-direction: column; justify-content: center">
            <p class="text-center" style="font-size: 28px; color: #ddd">
                <img src="image/student-school1.png" style="width: 180px"><br/>
                Gestion Ecole Authentification
            </p>
        </div>
            
        <div class="container" style="margin-top: 50px">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="alert" style="background-color: transparent">
                    <form method="post">
                        <div class="form-group <?php if(isset($erreur1) AND ($erreur1 == "oui")){ echo "has-error";} ?><?php if(isset($erreur3) AND ($erreur3 == "oui")){ echo "has-error";} ?>">
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#2c3b41; border-color:#2c3b41">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="text" class="form-control" name="mail" placeholder="Email" autofocus style="background-color:#2c3b41; color: white" value="<?php if(isset($mail)){echo $mail;} ?>">
                            </div>
                        </div>
                        
                        <div class="form-group <?php if(isset($erreur2) AND ($erreur2 == "oui")){ echo "has-error";} ?><?php if(isset($erreur3) AND ($erreur3 == "oui")){ echo "has-error";} ?>">
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color:#2c3b41; border-color:#2c3b41">
                                    <i class="fa fa-key"></i>
                                </span>
                                <input type="password" class="form-control" name="passe" style="background-color:#2c3b41; color: white" placeholder="Mot de passe">
                            </div>
                            <?php
                            if(isset($erreur3) AND ($erreur3 == "oui")){
                            ?>
                            <span class="help-block">Email ou mot de passe incorrect</span>
                            <?php
                            }
                            ?>
                        </div>
                        
                        <div class="form-group text-right" style="margin-top:30px; margin-bottom: 0">
                            <button class="btn btn-block" name="valider" style="text-align: left">
                                Valider
                                <i class="fa fa-sign-in pull-right" style="margin-top: 3px"></i>
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>