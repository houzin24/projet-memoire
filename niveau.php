<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM niveau WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: niveau.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Niveau / Gestion Ecole</title>
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
                    <li class="active">Niveau</li>
                    
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_niveau">Ajouter niveau</a></li>
                    <?php
                    }
                    ?>
                    
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Niveau</th>
                            <th>Filière</th>
                            <th>Année</th>
                            <th>Frais de formation</th>
                            
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
                    $req=$bdd->query('SELECT * FROM niveau ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                    ?>
                    <tr>
                        <td><?php echo $reponse['niveau']; ?></td>
                        <td><?php echo $reponse['filiere']; ?></td>
                        <td><?php echo $reponse['annee']; ?></td>
                        <td><?php echo $reponse['tarif'].' FCFA'; ?></td>
                        
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
                $('.niveau').removeClass('no');
                $('.niveau').addClass('select');
            });
        </script>
    </body>
</html>