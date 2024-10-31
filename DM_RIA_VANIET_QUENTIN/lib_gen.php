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

    function fusionnerComposantes($lab, $comp1, $comp2){
        // @param lab : labyrinthe
        // @param comp1 : composante 1
        // @param comp2 : composante 2
        // cette fonction fusionne deux composantes du labyrinthe en une seule

        foreach($lab as &$ligne){
            foreach($ligne as &$case){
                if($case['composante'] == $comp2){
                    $case['composante'] = $comp1;
                }
            }
        }
    }

    function genererLabyrintheVide($x, $y){
        // @param x : nombre de cases en ••••largeur
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
        // cette fonction génère un labyrinthe parfait à partir d'un labyrinthe vide et d'une graine
        if($seed != null){
            srand($seed);
        }
        else{
            srand((int)microtime(true));
        }
        $longueur = count($lab);
        $largeur = count($lab[0]);
        $nbMur = $longueur * $largeur - 1;
        $nbMurDetruit = 0;
        while($nbMurDetruit < $nbMur){
            $x = rand(0, $longueur - 1);
            $y = rand(0, $largeur - 1);
            $case = &$lab[$x][$y];
            $direction = rand(0, 3);
            if($direction == 0 && $x > 0){
                $case2 = &$lab[$x - 1][$y];
                if($case['composante'] != $case2['composante']){
                    $case['murN'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 1 && $x < $longueur - 1){
                $case2 = &$lab[$x + 1][$y];
                if($case['composante'] != $case2['composante']){
                    $case['murS'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 2 && $y < $largeur - 1){
                $case2 = &$lab[$x][$y + 1];
                if($case['composante'] != $case2['composante']){
                    $case['murE'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
            else if($direction == 3 && $y > 0){
                $case2 = &$lab[$x][$y - 1];
                if($case['composante'] != $case2['composante']){
                    $case['murO'] = 0;
                    fusionnerComposantes($lab, $case['composante'], $case2['composante']);
                    $nbMurDetruit++;
                }
            }
        }
    }

    function genererDepartArrivee($lab){
        // @param lab : labyrinthe
        // cette fonction génère une case de départ et une case d'arrivée dans le labyrinthe
        // Solution temporaire pour avoir une entrée et une sortie

        $longueur = count($lab);
        $largeur = count($lab[0]);
        $lab[0][0]['murN'] = 0;
        $lab[$longueur - 1][$largeur - 1]['murS'] = 0;
    }
    // Fonctions de resolution du labyrinthe

    function resoudreLabyrinthe($Lab){
        
    }

    // Fonctions d'affichage du labyrinthe

    function creerImageLabyrinthe($lab, $tuiles){
        // @param lab : labyrinthe
        // @param tuiles : tableau contenant les tuiles de l'image
        // @return img : image du labyrinthe
        // cette fonction génère une image à partir d'un labyrinthe et de tuiles

        $largeur = count($lab * imagesx($tuiles[0]));
        $hauteur = count($lab[0] * imagesy($tuiles[0]));
        $img = imagecreate($largeur, $hauteur);


        
    }

    function afficherLabyrintheresolu($lab, $solution){

    }

    function sectionnerTuile($img){
        // @param img : image à sectionner
        // @return tuiles : tableau contenant les tuiles de l'image
        // cette fonction sectionne une image en 6 tuiles

        $tuiles = array();ui ready
        }
    
        function rotationTuile($tuile, $rotation){
            // @param tuile : tuile à tourner
            // @param rotation : angle de rotation
            // @return tuile : tuile tournée
            // cette fonction tourne une tuile de l'image

            return imagerotate($tuile, $rotation, 0);
        }


?>