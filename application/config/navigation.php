<?php

return array(
    /*
    |------------------------------
    | Size
    |------------------------------
    |
    | This is the size of my thing.
    |
    */
    'sidenav'  => function() {
        $sidenav = File::get('application/json/sidenav.json');
        $sidenav = json_decode($sidenav,true);
        return $sidenav;
    },
);
