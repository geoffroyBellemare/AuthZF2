<?php

namespace Reservation;

return array(

    'controllers' => array(
        'factories' => array(
                'Reservation\Controller\Reservation' => 'Reservation\Controller\Factory\ReservationControllerFactory'
        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);