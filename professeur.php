<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM professeur WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: professeur.php');
}


if(isset($_GET['mod'])){
    $requete = $bdd->prepare('UPDATE professeur SET passe = "non" WHERE id = ?');
    $requete->execute(array($_GET['mod']));
    header('location: professeur.php');
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
                    <li class="active">Professeur</li>
                    
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_professeur">Ajouter professeur</a></li>
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
                            <th>Prenom</th>
                            <th>Sexe</th>
                            <th>Nationalité</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th>Mot de passe</th>
                            <th>Action</th>
                            <?php
                            }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM professeur ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                            
                            if($reponse['passe'] != "non"){
                                $passe = 'oui';
                            }else {
                                $passe = 'non';
                            }
                    ?>
                    <tr>
                        <td><?php echo $reponse['nom']; ?></td>
                        <td><?php echo $reponse['prenom']; ?></td>
                        <td><?php echo $reponse['sexe']; ?></td>
                        <td><?php echo $reponse['nationalite']; ?></td>
                        <td><?php echo $reponse['tel']; ?></td>
                        <td><?php echo $reponse['mail']; ?></td>
                        <td><?php echo $reponse['adresse']; ?></td>
                        
                        <?php
                        if($_SESSION['GEtype'] == 'Admin'){
                        ?>
                        <td><?php echo $passe; ?></td>
                        <td class="text-right">
                        <?php
                        if($passe == 'non'){
                         ?>
                            <a class="btn btn-primary btn-xs" href="ajout_prof_passe.php?id=<?php echo $reponse['id']; ?>&amp;nom=<?php echo $reponse['nom']; ?>&amp;prenom=<?php echo $reponse['prenom']; ?>">
                                Ajout mot de passe
                            </a>
                        <?php   
                        } else{
                        ?>
                            <a class="btn btn-default btn-xs" href="?mod=<?php echo $reponse['id'] ?>">supprimer mot de passe</a>
                        <?php
                        }
                        ?>
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
                $('.professeur').removeClass('no');
                $('.professeur').addClass('select');
            });
        </script>
    </body>
</html>