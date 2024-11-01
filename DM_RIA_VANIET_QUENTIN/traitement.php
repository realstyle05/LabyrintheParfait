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
        echo "Labyrinthe vide généré<br>";
        $lab_pf = creerLabyrintheParfait($labyrinthe);
        echo "Labyrinthe généré<br>";
        genererDepartArrivee($lab_pf['lab']);
        echo "Départ et arrivée générés<br>";
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);
        echo "Image générée<br>";
    }
    afficherComposante($lab_pf['lab']);
    echo "<img src='imageGenere/labyrinthe.png' alt='labyrinthe'/>";

?>
