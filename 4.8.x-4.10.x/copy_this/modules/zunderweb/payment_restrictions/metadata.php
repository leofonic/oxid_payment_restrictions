<?php

$aModule = array(
    'id'           => 'payment_restrictions',
    'title'        => 'Zunderweb Payment Restrictions',
    'description' =>  array(
        'de'=>'Mit diesem Modul k&ouml;nnen Sie f&uuml;r Artikel die einer bestimmten Kategorie angeh&ouml;ren bestimmte Zahlarten ausschlie&szlig;en, 
                diese Kategorie kann auch eine versteckte Kategorie sein. Ebenso k&ouml;nnen f&uuml;r Templates wie das mobile Template bestimmte Zahlarten 
                ausgeschlossen werden',
        'en'=>'With this module you can restrict payments for certain categories (also hidden categories) or themes.',
    ),
    'thumbnail'    => '',
    'version'      => '1.0',
    'extend' => array(
        'payment' => 'zunderweb/payment_restrictions/payment_restrictions_payment',
    ),
    'files' => array(
    ),
    'templates' => array(
    ),
    'blocks' => array(
    ),
);