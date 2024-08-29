<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM salle WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: salle.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Salle / Gestion Ecole</title>
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
                    <li class="active">Salle</li>
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_salle">Ajouter une salle</a></li>
                    <?php
                    }
                    ?>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Numéro</th>
                            <th>Type de salle</th>
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
                    $req=$bdd->query('SELECT * FROM salle ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                    ?>
                    <tr>
                        <td><?php echo $reponse['nom']; ?></td>
                        <td><?php echo $reponse['numero']; ?></td>
                        <td><?php echo $reponse['type']; ?></td>
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
                $('.salle').removeClass('no');
                $('.salle').addClass('select');
            });
        </script>
    </body>
</html>