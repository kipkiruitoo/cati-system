<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    // The prefix used in all base routes
    'route_prefix'              =>  'survey',

    // The prefix used in api endpoints
    'api_prefix'                =>  'api',

    // The prefix used in admin route
    'admin_prefix'              =>  'admin',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */

    // route middleware
    'route_middleware'          =>  ['web'],

    // api middleware
    'api_middleware'            =>  ['api'],

    // admin middleware
    'admin_middleware'          =>  ['web'],

    /*
    |--------------------------------------------------------------------------
    | Other config
    |--------------------------------------------------------------------------
    */

    // Pagination in admin section
    'pagination_perPage'        =>  12,

    // User model
    'user_model'                =>  'App\User',

    // Default locale for survey
    'locale'                    =>  'en',

    // Default theme for survey
    'theme'                     =>  'bootstrap',

    /*
    |--------------------------------------------------------------------------
    | SurveyJS Builder Configuration
    | More: https://surveyjs.io/Documentation/Builder/?id=surveyeditor
    |--------------------------------------------------------------------------
    */

    'builder'                   =>  [

        'theme'                 =>  'bootstrap',

        'showEmbededSurveyTab'  =>  true,

        'showJSONEditorTab'     =>  true,

        'showTestSurveyTab'     =>  true,

        'showPropertyGrid'      =>  true,

        'showOptions'           =>  true,

        'showState'             =>  true,

        'showLogicTab'          => true,
        'showTranslationTab' => true,

        'haveCommercialLicense' =>  true,
    ],

    /*
    |--------------------------------------------------------------------------
    | SurveyJS Custom Widgets
    |--------------------------------------------------------------------------
    */
    'widgets'                   =>  [

        'icheck'                =>  true,

        'select2'               =>  true,

        'inputmask'             =>  true,

        'jquerybarrating'       =>  true,

        'jqueryuidatepicker'    =>  true,

        'nouislider'            =>  true,

        'select2tagbox'         =>  true,

        'signaturepad'          =>  true,

        'sortablejs'            =>  true,

        'ckeditor'              =>  true,

        'autocomplete'          =>  true,


        'bootstrapslider'       =>  true,
    ],
];
