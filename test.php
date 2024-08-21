<?php
// $text ='wow';
// $int_a ='69';
// $int ='42';
// echo $int_a + $int;
    $myarray = [
        'Fruits'=>['apple', 'banana', 'cherry'],
        'Pets'=>['dog', 'cat', 'elephant'],
        'colors'=>['red', 'blue', 'green']
    ];
    echo ($myarray[1][2]);
    foreach($myarray as $category => $items){
        echo '<h1>'.$category.'</h1>';
        foreach($items as $item){
            echo '<p>'.$item.'</p>';
        }
    }
?>