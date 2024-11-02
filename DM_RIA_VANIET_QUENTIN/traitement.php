<?php
    include_once "lib_gen.php";

    // récupération de l'action
    $action = $_GET["generate"];

    // création du labyrinthe
    if($action == "Generer"){
        // récupération des paramètres
        $largeur = $_GET["x"];
        $hauteur = $_GET["y"];
        $seed = isset($_GET["seed"]) && $_GET["seed"] !== '' ? $_GET["seed"] : null;
        $tuiles = $_GET["tiles"];

        // récupération des tuiles
        $tuiles = "img_Tiles/".$tuiles;
        $tuiles = imagecreatefrompng($tuiles);
        $tab_tuiles = sectionnerTuile($tuiles);

        // génération du labyrinthe
        $labyrinthe = genererLabyrintheVide($largeur, $hauteur);
        $lab_pf = creerLabyrintheParfait($labyrinthe, $seed);
        genererDepartArrivee($lab_pf['lab']);
        creerImageLabyrinthe($lab_pf['lab'], $tab_tuiles);

        // Redirection vers Labyrinthe.html avec les paramètres nécessaires
        header("Location: Labyrinthe.html?generate=$action&seed=$lab_pf[seed]");
    }
    else if($action == "Exporter"){
        $newHauteur = $_GET["hauteur"];
        $newLargeur = $_GET["largeur"];
        redimensionnerImage("imageGenere/labyrinthe.png", $newLargeur, $newHauteur, "imageGenere/Labyrinthe.png");
        $name = 'imageGenere/Labyrinthe.png';
        header('Content-Type: application/PNG');
        header('Content-Disposition: attachment; filename="Labyrinthe.png"');
        header('Content-Length: ' . filesize($name));
        readfile($name);
        //header('Location : Labyrinthe.html');
    }
    exit();
?>
