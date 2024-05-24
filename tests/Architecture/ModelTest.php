<?php

arch('models should be classes')
    ->expect('App\Models')
    ->toBeClasses();

arch('models extends Eloquent Model')
    ->expect('App\Models')
    ->toExtend('Illuminate\Database\Eloquent\Model');

arch('models have suffix model')
    ->expect('App\Models')
    ->classes()
    ->toBeFinal();
