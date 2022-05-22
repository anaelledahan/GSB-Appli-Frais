<?php

/**
 * Gestion de de la validation des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau Anaelle <anaelledahan2001@gmail.com>
 * @version   GIT: <0>
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING); 
$idComptable = $_SESSION['idUtilisateur']; 
$moisActuel = getMois(date('d/m/Y')); 
$moisPrecedent = getMoisPrecedent($moisActuel); 
$fichesCL = $pdo->ficheDuDernierMoisCL($moisPrecedent); 
if (!$uc) { 
    $uc = 'validerFrais'; 
}
    
switch ($action) {
case 'choisirVisiteur':
    $lesVisiteurs = $pdo->getLesVisiteurs();
    $lesCles[]= array_keys($lesVisiteurs);
    $visiteurASelectionner = $lesCles[0];
   
    
    //$idVisiteur= filter_input (INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesMois = getLesDouzeDerniersMois($moisActuel);
    $lesCles[] = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    //var_dump($idVisiteur);
    include 'vues/v_listeDesVisiteurs.php';
    break;


case 'voirEtatFrais':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs=$pdo->getLesVisiteurs();
        $visiteurASelectionner=$idVisiteur;
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($moisActuel);
        $moisASelectionner=$mois;
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
         $libEtat = $lesInfosFicheFrais['libEtat'];
         $montantValide = $lesInfosFicheFrais['montantValide'];
         $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
         $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
         $_SESSION['idV'] = $idVisiteur; 
         $lesVisiteurs=$pdo->getLesVisiteurs();
         $visiteurASelectionner=$idVisiteur;
         $_SESSION['idM'] = $mois; 
         $lesMois = getLesDouzeDerniersMois($moisActuel);
         $moisASelectionner=$mois;
        if(is_array($lesInfosFicheFrais)){
            include 'vues/v_validerFrais.php';
            
        }
        else{
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            include 'vues/v_listeMois.php';
        }
        break;
        
    case 'validerMajFraisForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $idVisiteur= $_SESSION['idV']; 
    $lesVisiteurs=$pdo->getLesVisiteurs();
    $visiteurASelectionner=$idVisiteur;
    $mois= $_SESSION['idM']; 
    $lesMois = getLesDouzeDerniersMois($moisActuel);
    $moisASelectionner=$mois;
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
        include 'vues/v_validerFrais.php';
        
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    break;
    
case 'CorrigerElementHorsForfait': 
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    var_dump($idFrais);
    $pdo->supprimerFraisHorsForfait($idFrais);
    include 'vues/v_corrigerFraisHorsForfait.php';
    break; 
case 'actualiserNouvelElementHF';
    $idVisiteur= $_SESSION['idV'];
    $mois= $_SESSION['idM']; 
    $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    //var_dump($montant);//var_dump= afficher les informations d'une variable.
    valideInfosFrais($dateFrais, $libelle, $montant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        $pdo->creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $dateFrais,
            $montant
        );
    $lesVisiteurs=$pdo->getLesVisiteurs();
    $visiteurASelectionner=$idVisiteur;
    $lesMois = getLesDouzeDerniersMois($moisActuel);
    $moisASelectionner=$mois;
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    include 'vues/v_validerFrais.php';
    }
    break; 
case 'supprimerFraisHorsForfait';
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $pdo->supprimerFraisHorsForfait($idFrais);
    $idVisiteur= $_SESSION['idV'];
    $mois= $_SESSION['idM']; 
    $lesVisiteurs=$pdo->getLesVisiteurs();
    $visiteurASelectionner=$idVisiteur;
    $lesMois = getLesDouzeDerniersMois($moisActuel);
    $moisASelectionner=$mois;
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
    include 'vues/v_validerFrais.php';
break; 
case 'validerLaFicheDeFrais';
    $idVisiteur= $_SESSION['idV'];
    $mois= $_SESSION['idM'];
    $pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA');
    include 'vues/v_accueilComptable.php';
break; 
}

