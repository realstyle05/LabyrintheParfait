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
        echo "Génération du labyrinthe en cours...";
        $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
        $lab_pf = creerLabyrintheParfait($labyrinthe);
        genererDepartArrivee($lab_pf['lab']);
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);
    }

    echo "<img src='imageGenere/labyrinthe.png' alt='labyrinthe'/>";

?>
