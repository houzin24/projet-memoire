<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Emploi du temps / Gestion Ecole</title>
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
                    <li class="active">Emploi du temps</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col">
                <form method="post">
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Emploi du temps
                            </div>
                            <select class="form-control" style="width: 250px" onchange="this.form.submit()" name="niveau">
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                
                                $c = 1;
                                while($donnees = $requete->fetch()){
                                    if(isset($c) AND ($c == 1)){
                                        $select = $donnees['id'];
                                    }
                                    
                                    $c++;
                                ?>
                                <option <?php if(isset($_POST['niveau']) AND ($_POST['niveau'] == $donnees['id'])){echo "selected";} ?> value="<?php echo $donnees['id'] ?>"><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></option>
                                <?php
                                }
                                
                                
                                if(isset($_POST['niveau'])){
                                    $niveau = $_POST['niveau'];
                                    
                                } elseif(isset($_GET['niveau'])){
                                    $niveau = $_GET['niveau'];
                                    
                                } else{
                                    $niveau = $select;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <div class="col-md-6 text-right">
                        <div class="btn-group">
                            <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Modification</button>
                            <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu pull-left">
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                while($donnees = $requete->fetch()){
                                ?>
                                <li><a href="modification.php?niveau=<?php echo $donnees['id']; ?>"><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        
                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Ajouter une séance</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu pull-left">
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                while($donnees = $requete->fetch()){
                                ?>
                                <li><a href="seance.php?niveau=<?php echo $donnees['id']; ?>"><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                </form>
            </div>
            
            <div class="col-md-12" style="padding:15px; margin-top: 30px">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="info">Jour</th>
                            <?php
                            $requete = $bdd->query('SELECT * FROM heure');
                            while($donnees = $requete->fetch()){
                            ?>
                            <th><?php echo $donnees['heure']; ?></th>
                            <?php
                            }
                            $requete->closeCursor();
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="info">Lundi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Lundi"');
                            $requete->execute(array($niveau));
                            
                            $tableau1 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau1[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau1[1])){
                                    echo $tableau1[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[2])){
                                    echo $tableau1[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[3])){
                                    echo $tableau1[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[4])){
                                    echo $tableau1[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[5])){
                                    echo $tableau1[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[6])){
                                    echo $tableau1[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[7])){
                                    echo $tableau1[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau1[8])){
                                    echo $tableau1[8];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info">Mardi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Mardi"');
                            $requete->execute(array($niveau));
                            
                            $tableau2 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau2[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau2[1])){
                                    echo $tableau2[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[2])){
                                    echo $tableau2[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[3])){
                                    echo $tableau2[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[4])){
                                    echo $tableau2[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[5])){
                                    echo $tableau2[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[6])){
                                    echo $tableau2[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[7])){
                                    echo $tableau2[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau2[8])){
                                    echo $tableau2[8];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info">Mercredi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Mercredi"');
                            $requete->execute(array($niveau));
                            
                            $tableau3 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau3[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau3[1])){
                                    echo $tableau3[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[2])){
                                    echo $tableau3[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[3])){
                                    echo $tableau3[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[4])){
                                    echo $tableau3[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[5])){
                                    echo $tableau3[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[6])){
                                    echo $tableau3[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[7])){
                                    echo $tableau3[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau3[8])){
                                    echo $tableau3[8];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info">Jeudi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Jeudi"');
                            $requete->execute(array($niveau));
                            
                            $tableau4 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau4[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau4[1])){
                                    echo $tableau4[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[2])){
                                    echo $tableau4[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[3])){
                                    echo $tableau4[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[4])){
                                    echo $tableau4[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[5])){
                                    echo $tableau4[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[6])){
                                    echo $tableau4[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[7])){
                                    echo $tableau4[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau4[8])){
                                    echo $tableau4[8];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info">Vendredi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Vendredi"');
                            $requete->execute(array($niveau));
                            
                            $tableau5 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau5[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau5[1])){
                                    echo $tableau5[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[2])){
                                    echo $tableau5[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[3])){
                                    echo $tableau5[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[4])){
                                    echo $tableau5[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[5])){
                                    echo $tableau5[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[6])){
                                    echo $tableau5[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[7])){
                                    echo $tableau5[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau5[8])){
                                    echo $tableau5[8];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="info">Samedi</td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ? AND jour = "Samedi"');
                            $requete->execute(array($niveau));
                            
                            $tableau6 = array();
                            while($donnees = $requete->fetch()){
                                $requete1 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete1->execute(array($donnees['id_matiere']));
                                $donnees1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete2->execute(array($donnees['id_heure']));
                                $donnees2 = $requete2->fetch();
                                
                                $tableau6[$donnees2['id']] = $donnees1['matiere'];
                            }
                            ?>
                            <td>
                                <?php
                                if(isset($tableau6[1])){
                                    echo $tableau6[1];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[2])){
                                    echo $tableau6[2];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[3])){
                                    echo $tableau6[3];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[4])){
                                    echo $tableau6[4];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[5])){
                                    echo $tableau6[5];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[6])){
                                    echo $tableau6[6];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[7])){
                                    echo $tableau6[7];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(isset($tableau6[8])){
                                    echo $tableau6[8];
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.emploi').removeClass('no');
                $('.emploi').addClass('select');
            });
        </script>
    </body>
</html>