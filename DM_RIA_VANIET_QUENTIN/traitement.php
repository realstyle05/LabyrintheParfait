<?php
    include_once "lib_gen.php";

    // importation des tuiles et récupération des variables
    
    $largeur = $_GET["x"];
    $hauteur = $_GET["y"];
    $action = $_GET["generate"];
    $seed = isset($_GET["seed"]) && $_GET["seed"] !== '' ? $_GET["seed"] : null;
    $tuiles = $_GET["tiles"];
    // traitement des tuiles
    $tuiles = "img_Tiles/".$tuiles;
    $tuiles = imagecreatefrompng($tuiles);
    $tab_tuiles = sectionnerTuile($tuiles);

    // création du labyrinthe
    if($action == "Generer"){
        $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
        $lab_pf = creerLabyrintheParfait($labyrinthe, $seed);
        genererDepartArrivee($lab_pf['lab']);
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);

    }
    // Redirection vers Labyrinthe.html
    header("Location: Labyrinthe.html?generate=$action&seed=$lab_pf[seed]");
    exit();
?>
