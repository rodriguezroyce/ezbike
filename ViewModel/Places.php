<?php
    $location = array(
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Cavite+City%2C+Cavite%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/cavite.jpg","image-element"=>"cavite","p-class"=>"text-inside","p-element"=>"Cavite"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Cebu%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/cebu.jpg","image-element"=>"cebu","p-class"=>"text-inside","p-element"=>"Cebu"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Pampanga%2C+Angeles%2C+Pampanga%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/pampanga.jfif","image-element"=>"cebu","p-class"=>"text-inside","p-element"=>"Pampanga"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Davao+City%2C+Davao+del+Sur%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/davao.jpg","image-element"=>"davao","p-class"=>"text-inside","p-element"=>"Davao"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Ilocos+Norte%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/ilocos.jpg","image-element"=>"ilocos","p-class"=>"text-inside","p-element"=>"Ilocos"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Calamba%2C+Laguna%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/laguna.jpg","image-element"=>"laguna","p-class"=>"text-inside","p-element"=>"Laguna"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Manila%2C+Metro+Manila%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/manila.jpg","image-element"=>"manila","p-class"=>"text-inside","p-element"=>"Manila"),
        array("boxData"=> "col-md-3 box","link-class"=>"cities","link-rel"=>"./View/search.php?location=Bulacan%2C+Philippines&location_search=","img-class"=>"img-Container","img-src"=>"./assets/img/bulacan.jpg","image-element"=>"bulacan","p-class"=>"text-inside","p-element"=>"Bulacan")
    );
        foreach($location as $key => $values){
            $string_1 = $values["boxData"];
            $string_2 = $values["link-class"];
            $string_3 = $values["link-rel"];
            $string_4 = $values["img-class"];
            $string_5 = $values["img-src"];
            $string_6 = $values["image-element"];
            $string_7 = $values["p-class"];
            echo "<div class=\"$string_1\"> ";
            echo "<a class=\"$string_2\" href=\"$string_3\"> <img class=\"$string_4\" src=\"$string_5\" alt=\"$string_6\"></a>";
            echo "<p class=\"$string_7\">". $values["p-element"] ." </p>";
            echo "</div>";
        }
?>