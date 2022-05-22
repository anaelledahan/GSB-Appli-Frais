<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

//require_once: ce fichier doit etre ouvert obligatoirement pour que le fichier s'ouvre 
require_once 'includes/fct.inc.php'; 
require_once 'includes/class.pdogsb.inc.php';

//session_start: methode parce que (), fonction qui démare la superglobale(elle peut jongler entre les differenes table ) session 
session_start();
$pdo = PdoGsb::getPdoGsb();//toute les variable $ devant. pdo:variable, on lui affecte le resultat de la mthode getPdoGsb() qui esr dans la classe PdoGsb
 // $estConnecte = estConnecte(); // = on lui affecte

$estConnecte = (estComptableConnecte()| estVisiteurConnecte());
$estComptableConnecte = estComptableConnecte();
$estVisiteurConnecte = estVisiteurConnecte();
$estConnecte = estConnecte();

require 'vues/v_entete.php';
//uc: une variable superglobale qui nous renseigne le controleur

$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);

if ($uc && !$estConnecte) {
   $uc = 'connexion';
} elseif (empty($uc)) {
   $uc = 'accueil';// uc: variable super globale qui nous renseigne le controleur
}
//switch c'est comme if 
switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
//uc = gererfrais, action = etatfrais
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
case 'validerFrais':
    include 'controleurs/c_validerFrais.php';
    break;
case 'suiviPaiement':
    include 'controleurs/c_suiviPaiement.php';
    break;
}
require 'vues/v_pied.php';
