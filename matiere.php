<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM matiere WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: matiere.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Matière / Gestion Ecole</title>
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
                    <li class="active">Matière</li>
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_matiere">Ajouter matière</a></li>
                    <?php
                    }
                    ?>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Matière</th>
                            <th>Niveau</th>
                            <th>Professeur</th>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th>Action</th>
                            <?php
                            }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM matiere ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="4">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                    ?>
                    <tr>
                        <td><?php echo $reponse['matiere']; ?></td>
                        <td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
                            $requete->execute(array($reponse['niveau']));
                            $donnees = $requete->fetch();
                            echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM professeur WHERE id = ?');
                            $requete->execute(array($reponse['prof']));
                            $donnees = $requete->fetch();
                            echo $donnees['nom'].' '.$donnees['prenom'];
                            ?>
                        </td>
                        
                        <?php
                        if($_SESSION['GEtype'] == 'Admin'){
                        ?>
                        <td class="text-center">
                            <a class="btn btn-danger btn-xs" href="?sup=<?php echo $reponse['id'] ?>">Supprimer</a>
                        </td>
                        <?php
                        }
                        ?>
                        
                    </tr>
                    <?php
                        }while($reponse = $req->fetch());
                    }
                    ?>
                        
                    </tbody>
                </table>
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