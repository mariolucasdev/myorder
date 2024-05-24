<?php

arch('controllers should be controller')
    ->expect('App\Controllers')
    ->toBeClasses();

arch('controllers extends controller')
    ->expect('App\Controllers')
    ->toExtend('App\Controllers\Controller');

arch('controllers have suffix controller')
    ->expect('App\Controllers')
    ->toHaveSuffix('Controller');

arch('controllers have constructor')
    ->expect('App\Controllers')
    ->toHaveConstructor();
