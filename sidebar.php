<div class="sidebar mCustomScrollbar" data-mcs-theme="minimal-dark" id="sidebar">
    <div class="logo text-center">
        <img src="image/student-school1.png" style="width: 180px">
    </div>
    <div class="panel panel-default panel1" style="border-left: none">
         <ul class="list-group">
             
            <a href="accueil" class="list-group-item no accueil"><i class="fa fa-tachometer"></i> Accueil</a> 
            <a href="etudiant" class="list-group-item no etudiant"><i class="fa fa-users"></i> Etudiants</a>
            <a href="professeur" class="list-group-item no professeur"><i class="fa fa-male"></i> Professeurs</a>
             
             <?php
            if($_SESSION['GEtype'] == 'Admin'){
            ?>
            <a href="parent" class="list-group-item no parent"><i class="fa fa-user"></i> Parents</a>
            <?php
            }
            ?>
             
            <a href="personnel" class="list-group-item no personnel"><i class="fa fa-male"></i> Personnel</a>
            <a href="niveau" class="list-group-item no niveau"><i class="fa fa-sitemap"></i> Niveau</a>
            <a href="matiere" class="list-group-item no matiere"><i class="fa fa-file-text-o"></i> Matières</a>
            <a href="emploi_du_temps" class="list-group-item no emploi"><i class="fa fa-table"></i> Emploi du temps</a>
            <a href="cahier" class="list-group-item no cahier"><i class="fa fa-book"></i> Cahier de test</a>
            
            <?php
            if($_SESSION['GEtype'] == 'Admin'){
            ?>
            <a href="annee" class="list-group-item no annee"><i class="fa fa-calendar"></i> Année scolaire</a>
            <?php
            }
            ?>
             
            <?php
            if($_SESSION['GEtype'] == 'Admin'){
            ?>
            <a href="payement" class="list-group-item no payement"><i class="fa fa-money"></i> Payements</a>
            <?php
            }
            ?>
             
            
            <a href="activite" class="list-group-item no activite"><i class="fa fa-dribbble"></i> Activités</a>
            <a href="salle" class="list-group-item no salle"><i class="fa fa-home"></i> Salle</a>
            <a href="absence" class="list-group-item no absence"><i class="fa fa-question"></i> Absence</a>
            <a href="compte" class="list-group-item no compte"><i class="fa fa-lock"></i> Compte</a>
         </ul>
    </div>
</div>