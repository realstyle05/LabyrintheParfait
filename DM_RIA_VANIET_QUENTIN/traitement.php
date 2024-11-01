<?php
    include_once "lib_gen.php";

    // importation des tuiles et récupération des variables

    $largeur = $_GET["x"];
    $hauteur = $_GET["y"];

    // traitement des tuiles

    $tuiles = imagecreatefrompng("img_Tiles/2D_Maze_Tiles_White.png");
    $tab_tuiles = sectionnerTuile($tuiles);

    // création du labyrinthe

    $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
    $lab_pf = creerLabyrintheParfait($labyrinthe);
    genererDepartArrivee($lab_pf['lab']);
    
    $imagePath = creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);

    header('Content-Type: image/png');
    readfile($imagePath);

?>
