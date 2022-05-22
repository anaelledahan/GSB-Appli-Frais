<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


  
        <form method= "post"
              action="index.php?uc=validerFrais&action=voirEtatFrais" 
              role="form">
        <div class="col-md-4">
            <div class="form-group" style="display : inline-block">
                <label for="lstVisiteurs" accesskey="n"> Choisir le visiteur: </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($unVisiteur == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>    
                </select>
            </div>
             
            <div class="form-group" style = "display:inline-block" >
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
             <button class="btn btn-success" type="submit">valider</button> 
    </div>
</form>

    
    
    
    

 <br><br><br><br>
 <div class="row">    
    <h2 style="color: orangered"> Valider la fiche de frais</h2>
    <h3>Eléments forfaitisés</h3>
    
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=validerFrais&action=validerMajFraisForfait" 
              role="form">
            <fieldset> 
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>

                    <?php
                }
             ?>
                <button class="btn btn-success" type="submit">Corriger</button> <!--submit pour envoyer --> 
                <button class="btn btn-danger" type="reset">Réinitialiser</button> <!--reset pour effacer reinitialiser a 0--> 

            </fieldset>
 </form>
    </div>
</div>







<hr>
<div class="row">
    
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <td> <?php echo $date ?></td>
                    <td> <?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                    <td><a href="index.php?uc=validerFrais&action=CorrigerElementHorsForfait&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment corriger ce frais?');"><button class="btn btn-success" type="submit">Corriger</button></a></td>
                    <td><a href="index.php?uc=validerFrais&action=supprimerFraisHorsForfait&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">
                            <button class="btn btn-danger" type="submit">supprimer</button></a></td>
           
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
 
    </div>
    
</div>
  <a href="index.php?uc=validerFrais&action=validerLaFicheDeFrais&idFrais=<?php echo $id ?>" 
    ><button class="btn btn-success" type="submit">Valider la fiche de frais</button></a>
