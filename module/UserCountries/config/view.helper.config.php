<?php

use UserCountries\View\Helper\UserCountries;

return array(
    'factories' => array(
        'UserCountries' => function($sm) {
            return new UserCountries($sm->getServiceLocator()->get('Request'));
        }
    )
);