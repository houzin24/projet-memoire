<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>

<?php
if(isset($_POST['valider'])){
    
    if(trim($_POST['debut'])){
        $debut = htmlspecialchars($_POST['debut']);
    } else{
        $erreur1 = "oui";
    }
    
    if(trim($_POST['fin'])){
        $fin = htmlspecialchars($_POST['fin']);
    } else{
        $erreur2 = "oui";
    }
    
    
    if(isset($debut) AND isset($fin)){
        $requete = $bdd->prepare('INSERT INTO annees VALUES("", ?, ?)');
        $requete->execute(array($debut, $fin));
        
        $_SESSION['GEdebut'] = $debut;
        $_SESSION['GEfin'] = $fin;
        
        header('location: annee.php');
    }
}




if(isset($_GET['supp'])){
    $requete = $bdd->prepare('DELETE FROM annees WHERE id = ?');
    $requete->execute(array($_GET['supp']));
    
    $req=$bdd->query('SELECT * FROM annees ORDER BY id DESC');
    if(FALSE == ($reponse = $req->fetch())){

        $_SESSION['GEdebut'] = '';
        $_SESSION['GEfin'] = '';

    } else{
        $_SESSION['GEdebut'] = $reponse['debut'];
        $_SESSION['GEfin'] = $reponse['fin'];
    }
    
    header('location: annee.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Année scolaire / Gestion Ecole</title>
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
                    <li class="active">Année scolaire</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-6">
                <legend>Les années scolaire</legend>
                
                <ul class="list-group">
                <?php
                $req=$bdd->query('SELECT * FROM annees ORDER BY id DESC');
                if(FALSE == ($reponse = $req->fetch())){
                ?>
                <a class="list-group-item">Pas d'enregistrement</a>
                <?php
                } else{
                    do{
                ?>
                <li class="list-group-item"> 
                    <?php echo 'Année scolaire '.$reponse['debut'].' - '.$reponse['fin'] ?>
                    <a href="?supp=<?php echo $reponse['id'] ?>" class="btn btn-warning btn-xs pull-right">Supprimer</a>
                </li>
                <?php
                    }while($reponse = $req->fetch());
                }
                ?>
                </ul>
            </div>
            
            <div class="col-md-5 col-md-offset-1" style="border: 1px solid #ccc; margin-top: 30px; border-radius: 4px; padding-top: 20px">
                <legend>Ajouter année scolaire</legend>
                <form method="post">
                    <div class="col-md-6" style="padding-left: 0">
                        <div class="form-group <?php if(isset($erreur1)){echo 'has-error'; } ?>">
                            <span>Année début</span>

                            <div class="input-group date years" data-provide="years">
                                <input type="text" class="form-control" name="debut">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6" style="padding-right: 0">
                        <div class="form-group <?php if(isset($erreur2)){echo 'has-error'; } ?>">
                            <span>Année fin</span>

                            <div class="input-group date years" data-provide="years">
                                <input type="text" class="form-control" name="fin">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
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
                $('.annee').removeClass('no');
                $('.annee').addClass('select');
                
                
                
                $('.years').datepicker({
                    format: 'yyyy',
                    viewMode: 'years',
                    minViewMode: 'years',
                    autoclose: 'false'
                });
                
                
            });
        </script>
    </body>
</html>