<?php
    include_once "lib_gen.php";

    // importation des tuiles et récupération des variables

    $gen = $_GET["generate"];
    $largeur = $_GET["x"];
    $hauteur = $_GET["y"];

    // traitement des tuiles

    $tuiles = imagecreatefrompng("img_Tiles/2D_Maze_Tiles_White.png");
    $tab_tuiles = sectionnerTuile($tuiles);

    // création du labyrinthe

    $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
    $lab_pf = creerLabyrintheParfait($labyrinthe);
    genererDepartArrivee($lab_pf['lab']);
        
    if ($gen == "Generer") {
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);
    } 
    else {
        echo "<p>a traiter</p>";
        console.log("a");
    }

?>
