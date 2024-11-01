<?php
    include_once "lib_gen.php";

    // importation des tuiles et récupération des variables

    $largeur = $_GET["x"];
    $hauteur = $_GET["y"];
    $tuiles = imagecreatefrompng("img_Tiles/2D_Maze_Tiles_Red.png");

    // handle failed importation case

    if (!$tuiles) echo "Import failed";
    else {
        $tab_tuiles = sectionnerTuile($tuiles);
        $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
        $lab_pf = creerLabyrintheParfait($labyrinthe);
        creerImageLabyrinthe($lab_pf, $tab_tuiles);
        

    }
?>