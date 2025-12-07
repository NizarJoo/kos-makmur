<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'after' => 'Bidang :attribute harus berupa tanggal setelah :date.',
    'min' => [
        'numeric' => 'Bidang :attribute harus setidaknya :min.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given rule attribute.
    |
    */

    'custom' => [
        'end_date' => [
            'after' => 'Tanggal berakhir harus setelah tanggal mulai.',
        ],
        'duration_months' => [
            'min' => 'Minimal memesan kamar kos 1 bulan.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'end_date' => 'tanggal berakhir',
        'start_date' => 'tanggal mulai',
        'duration_months' => 'durasi bulan',
    ],

];
