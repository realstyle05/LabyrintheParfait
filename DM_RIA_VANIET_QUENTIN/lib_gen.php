<?php
    // Fonctions de generation du labyrinthe et des cases
    
    function genererCase($id){
        // @param id : prend en paramètre l'id de la case à générer
        // @return case : retourne un tableau associatif représentant la case générée
        // cette fonction génère une case avec des murs de partout

        $case = array();
        $case['id'] = $id;
        $case['composante'] = $id;
        $case['murN'] = 1;
        $case['murS'] = 1;
        $case['murE'] = 1;
        $case['murO'] = 1;
        return $case;
    }

    function fusionnerComposantes(&$lab, $comp1, $comp2){
        // @param lab : labyrinthe
        // @param comp1 : composante 1
        // @param comp2 : composante 2
        // cette fonction fusionne deux composantes du labyrinthe en une seule

        for($i = 0; $i < count($lab); $i++){
            for($j = 0; $j < count($lab[0]); $j++){
                if($lab[$i][$j]['composante'] == $comp2){
                    $lab[$i][$j]['composante'] = $comp1;
                }
            }
        }
    }

    function genererLabyrintheVide($x, $y){
        // @param x : nombre de cases en largeur
        // @param y : nombre de cases en hauteur
        // @return labyrinthe : retourne un tableau à deux dimensions représentant le labyrinthe vide
        // cette fonction génère un labyrinthe de cases avec des murs de partout

        $labyrinthe = array();
        $compteur = 0;
        for($i = 0; $i < $x; $i++){
            for($j = 0; $j < $y; $j++){
                $labyrinthe[$i][$j] = genererCase($compteur);
                $compteur++;
            }
        }
        return $labyrinthe;
    }

    function creerLabyrintheParfait($lab, $seed = null){
        // @param lab : labyrinthe
        // @param seed : graine pour la génération aléatoire (est le temps depuis la création de unix)
        // @return lab : retourne un tableau à deux dimensions représentant le labyrinthe parfait
        // cette fonction génère un labyrinthe parfait à partir d'un labyrinthe vide et d'une graine
        if($seed != null){
            srand($seed);
        }
        else{
            $seed = (int)microtime(true);
            srand($seed);
        }
        $longueur = count($lab);
        $largeur = count($lab[0]);
        $nbMur = $longueur * $largeur - 1;
        $nbMurDetruit = 0;
        while(!verifierComposantes($lab) && $nbMurDetruit < $nbMur){
            $x = rand(0, $longueur - 1);
            $y = rand(0, $largeur - 1);
            $case = &$lab[$x][$y];
            $direction = rand(0, 3);
            if($direction == 0 && $x > 0){
                $case2 = &$lab[$x - 1][$y];
                if($case['composante'] != $case2['composante']){
                    $case['murN'] = 0;
                    $lab[$x - 1][$y]['murS'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 1 && $x < $longueur - 1){
                $case2 = &$lab[$x + 1][$y];
                if($case['composante'] != $case2['composante']){
                    $case['murS'] = 0;
                    $lab[$x + 1][$y]['murN'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 2 && $y < $largeur - 1){
                $case2 = &$lab[$x][$y + 1];
                if($case['composante'] != $case2['composante']){
                    $case['murE'] = 0;
                    $lab[$x][$y + 1]['murO'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 3 && $y > 0){
                $case2 = &$lab[$x][$y - 1];
                if($case['composante'] != $case2['composante']){
                    $case['murO'] = 0;
                    $lab[$x][$y - 1]['murE'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
        }
        return ['lab' => $lab, 'seed' => $seed];
    }

    function genererDepartArrivee(&$lab){
        // @param lab : labyrinthe
        // cette fonction génère une case de départ et une case d'arrivée dans le labyrinthe
        // Solution temporaire pour avoir une entrée et une sortie

        $longueur = count($lab);
        $largeur = count($lab[0]);
        $lab[0][0]['murN'] = 0;
        $lab[$longueur - 1][$largeur - 1]['murS'] = 0;
    }

    // Fonctions d'affichage du labyrinthe

    function creerImageLabyrinthe($lab, $tuiles){
        // @param lab : labyrinthe
        // @param tuiles : tableau contenant les tuiles de l'image
        // cette fonction génère une image à partir d'un labyrinthe et de tuiles

        $largeur = count($lab[0]) * imagesx($tuiles[0]);
        $hauteur = count($lab) * imagesy($tuiles[0]);
        $img = imagecreate($largeur, $hauteur);
        //on parcourt le labyrinthe pour afficher les tuiles
        for($i = 0; $i < count($lab); $i++){
            for($j = 0; $j < count($lab[0]); $j++){
                $case = $lab[$i][$j];
                
                //on recherche le nombre de bords sans murs de chaque case 
                //afin de selectionner la bonne tuile
                $nbTrou = 4 - $case['murN'] - $case['murS'] - $case['murE'] - $case['murO'];
                //on selectionne la tuile correspondante
                if($nbTrou == 1){
                    $tuile = $tuiles[2];
                    $numTuile = 2;
                }
                else if($nbTrou == 2){
                    //on a deux cas de figure, un coude ou une ligne
                    if(($case['murN'] && $case['murS']) || ($case['murE'] && $case['murO'])){
                        $tuile = $tuiles[4];
                        $numTuile = 4;
                    }
                    else{
                        $tuile = $tuiles[1];
                        $numTuile = 1;
                    }
                }
                else if($nbTrou == 3){
                    $tuile = $tuiles[3];
                    $numTuile = 3;
                }
                else if($nbTrou == 4){
                    $tuile = $tuiles[0];
                    $numTuile = 0;
                }
                //on trouve la bonne rotation pour la tuile
                if($numTuile == 2){
                    if($case['murN'] == 0){
                        $rotation = 180;
                    }
                    else if($case['murE'] == 0){
                        $rotation = 90;
                    }
                    else if($case['murS'] == 0){
                        $rotation = 0;
                    }
                    else if($case['murO'] == 0){
                        $rotation = 270;
                    }
                }
                else if($numTuile == 1){
                    if($case['murN'] == 0){
                        if($case['murE'] == 0){
                            $rotation = 180;
                        }
                        else if($case['murO'] == 0){
                            $rotation = 270;
                        }
                    }
                    else if($case['murS'] == 0){
                        if($case['murE'] == 0){
                            $rotation = 90;
                        }
                        else if($case['murO'] == 0){
                            $rotation = 0;
                        }
                    }
                }
                else if($numTuile == 4){
                    if($case['murN'] == 0 && $case['murS'] == 0){
                        $rotation = 0;
                    }
                    else if ($case['murE'] == 0 && $case['murO'] == 0) {
                        $rotation = 270;
                    }
                }
                else if($numTuile == 3){
                    if($case['murN']){
                        $rotation = 90;
                    }
                    else if($case['murE']){
                        $rotation = 0;
                    }
                    else if($case['murS']){
                        $rotation = 270;
                    }
                    else if($case['murO']){
                        $rotation = 180;
                    }
                }
                else if($numTuile == 0){
                    $rotation = 0;
                }
                //on tourne la tuile
                $tuile = rotationTuile($tuile, $rotation);
                //on colle la tuile sur l'image
                imagecopy($img, $tuile, $j * imagesx($tuile), $i * imagesy($tuile), 0, 0, imagesx($tuile), imagesy($tuile));
            }
        }
        imagepng($img, "imageGenere/labyrinthe.png");
        imagedestroy($img);
    }

    function sectionnerTuile($img){
        // @param img : image à sectionner
        // @return tuiles : tableau contenant les tuiles de l'image
        // cette fonction sectionne une image en 6 tuiles

        $tuiles = array();
        $largeur = imagesx($img) / 5;
        $hauteur = imagesy($img);
        for($i = 0; $i < 5; $i++){
            $tuile = imagecreatetruecolor($largeur, $hauteur);
            imagecopy($tuile, $img, 0, 0, $i * $largeur, 0, $largeur, $hauteur);
            $tuiles[$i] = $tuile;
        }
        return $tuiles;
    }

    
        function rotationTuile($tuile, $rotation){
            // @param tuile : tuile à tourner
            // @param rotation : angle de rotation
            // @return tuile : tuile tournée
            // cette fonction tourne une tuile de l'image

            return imagerotate($tuile, $rotation, 0);
        }

        //fonction de debug

        function afficherMatriceLab($lab){
            // @param lab : labyrinthe
            // cette fonction affiche le labyrinthe

            foreach($lab as $ligne){
                foreach($ligne as $case){
                    echo $case['murN'] . " ";
                    echo $case['murS'] . " ";
                    echo $case['murE'] . " ";
                    echo $case['murO'] . " ";
                    echo " | ";
                }
                echo "<br>";
            }
        }

        function afficherComposante($lab){
            // @param lab : labyrinthe
            // cette fonction affiche les composantes du labyrinthe

            foreach($lab as $ligne){
                foreach($ligne as $case){
                    echo $case['composante'] . " ";
                }
                echo "<br>";
            }
        }

        function verifierComposantes($lab) {
            // @param lab : labyrinthe
            // @return boolean : retourne vrai si toutes les cases du labyrinthe appartiennent à la même composante, faux sinon
            $composanteInitiale = $lab[0][0]['composante'];
            for ($i = 0; $i < count($lab); $i++) {
                for ($j = 0; $j < count($lab[0]); $j++) {
                    if ($lab[$i][$j]['composante'] != $composanteInitiale) {
                        return false;
                    }
                }
            }
            return true;
        }

        //fonction de redimentionnement de l'image
        
        function redimensionnerImage($sourceFile, $largeur, $hauteur, $outputFile){
            // @param sourceFile : chemin de l'image source
            // @param largeur : nouvelle largeur de l'image
            // @param hauteur : nouvelle hauteur de l'image
            // @param outputFile : chemin du fichier de sortie
            // cette fonction redimensionne une image existante aux dimensions spécifiées
        
            // Charger l'image source
            $sourceImage = imagecreatefrompng($sourceFile);
        
            // Obtenir les dimensions de l'image source
            $largeurSource = imagesx($sourceImage);
            $hauteurSource = imagesy($sourceImage);
        
            // Créer une nouvelle image avec les dimensions spécifiées
            $imageRedimensionnee = imagecreatetruecolor($largeur, $hauteur);
        
            // Redimensionner l'image
            imagecopyresampled($imageRedimensionnee, $sourceImage, 0, 0, 0, 0, $largeur, $hauteur, $largeurSource, $hauteurSource);
        
            // Sauvegarder l'image redimensionnée
            imagepng($imageRedimensionnee, $outputFile);
        
            // Libérer la mémoire
            imagedestroy($sourceImage);
            imagedestroy($imageRedimensionnee);
        }
        

?>