<?php

return  [
  'laravel-lang/actions' => [
    'providers' => [
      0 => 'LaravelLang\\Actions\\ServiceProvider',
    ],
  ],
  'laravel-lang/attributes' => [
    'providers' => [
      0 => 'LaravelLang\\Attributes\\ServiceProvider',
    ],
  ],
  'laravel-lang/config' => [
    'providers' => [
      0 => 'LaravelLang\\Config\\ServiceProvider',
    ],
  ],
  'laravel-lang/http-statuses' => [
    'providers' => [
      0 => 'LaravelLang\\HttpStatuses\\ServiceProvider',
    ],
  ],
  'laravel-lang/lang' => [
    'providers' => [
      0 => 'LaravelLang\\Lang\\ServiceProvider',
    ],
  ],
  'laravel-lang/locales' => [
    'providers' => [
      0 => 'LaravelLang\\Locales\\ServiceProvider',
    ],
  ],
  'laravel-lang/models' => [
    'providers' => [
      0 => 'LaravelLang\\Models\\ServiceProvider',
    ],
  ],
  'laravel-lang/moonshine' => [
    'providers' => [
      0 => 'LaravelLang\\MoonShine\\ServiceProvider',
    ],
  ],
  'laravel-lang/publisher' => [
    'providers' => [
      0 => 'LaravelLang\\Publisher\\ServiceProvider',
    ],
  ],
  'laravel-lang/routes' => [
    'providers' => [
      0 => 'LaravelLang\\Routes\\ServiceProvider',
    ],
  ],
  'laravel-lang/starter-kits' => [
    'providers' => [
      0 => 'LaravelLang\\StarterKits\\ServiceProvider',
    ],
  ],
  'laravel/pail' => [
    'providers' => [
      0 => 'Laravel\\Pail\\PailServiceProvider',
    ],
  ],
  'laravel/sail' => [
    'providers' => [
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ],
  ],
  'laravel/socialite' => [
    'aliases' => [
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ],
    'providers' => [
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ],
  ],
  'laravel/tinker' => [
    'providers' => [
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ],
  ],
  'nesbot/carbon' => [
    'providers' => [
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ],
  ],
  'nunomaduro/collision' => [
    'providers' => [
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ],
  ],
  'nunomaduro/termwind' => [
    'providers' => [
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ],
  ],
  'socialiteproviders/manager' => [
    'providers' => [
      0 => 'SocialiteProviders\\Manager\\ServiceProvider',
    ],
  ],
  'spatie/laravel-query-builder' => [
    'providers' => [
      0 => 'Spatie\\QueryBuilder\\QueryBuilderServiceProvider',
    ],
  ],
  'tymon/jwt-auth' => [
    'aliases' => [
      'JWTAuth'    => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
    ],
    'providers' => [
      0 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
    ],
  ],
];