<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM personnel WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: personnel.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Personnel / Gestion Ecole</title>
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
                    <li class="active">Personnel</li>
                    
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_personnel">Ajouter un Personnel</a></li>
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
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>Profession</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            
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
                    $req=$bdd->query('SELECT * FROM personnel ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                    ?>
                    <tr>
                        <td><?php echo $reponse['nom']; ?></td>
                        <td><?php echo $reponse['prenom']; ?></td>
                        <td><?php echo $reponse['sexe']; ?></td>
                        <td><?php echo $reponse['profession']; ?></td>
                        <td><?php echo $reponse['tel']; ?></td>
                        <td><?php echo $reponse['adresse']; ?></td>
                        
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
                $('.personnel').removeClass('no');
                $('.personnel').addClass('select');
            });
        </script>
    </body>
</html>