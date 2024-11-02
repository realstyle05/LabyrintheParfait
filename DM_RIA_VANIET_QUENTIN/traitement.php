<?php
    include_once "lib_gen.php";

    // importation des tuiles et récupération des variables
    
    $largeur = $_GET["x"];
    $hauteur = $_GET["y"];
    $action = $_GET["generate"];
    
    // traitement des tuiles

    $tuiles = imagecreatefrompng("img_Tiles/2D_Maze_Tiles_White.png");
    $tab_tuiles = sectionnerTuile($tuiles);

    // création du labyrinthe
    if($action == "Generer"){
        $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
        $lab_pf = creerLabyrintheParfait($labyrinthe);
        genererDepartArrivee($lab_pf['lab']);
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);

    }
    // Redirection vers Labyrinthe.html
    header("Location: Labyrinthe.html?generate=$action");
    exit();
?>
