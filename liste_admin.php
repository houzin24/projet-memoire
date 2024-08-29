<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM users WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: liste_admin.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Professeur / Gestion Ecole</title>
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
                    <li><a href="compte.php">Compte</a></li>
                    <li class="active">Liste des admin</li>
                    
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM users ORDER BY id DESC');
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
                        <td><?php echo $reponse['mail']; ?></td>
                        <td class="text-center">
                            <a class="btn btn-danger btn-xs" href="?sup=<?php echo $reponse['id'] ?>">Supprimer</a>   
                        </td>
                        
                        
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
                $('.compte').removeClass('no');
                $('.compte').addClass('select');
            });
        </script>
    </body>
</html>