project name: home-life-app

setup: [
    - composer global require laravel/installer // only install first time
    - laravel new home-life-app // (laravel new) use in every new app installing
]

routes: [
    - group
    - prifex
    - namespace
    - name : as
    - controller
    - middleware
    - resource
],

RouteServiceProvider : [
    - dynamic controller namespace [
        
        protected $namespace = 'App\Http\Controllers';
    
        Route::middleware('web')
            // AMA-routes controller namespace
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    ]
]

migrations: [
    - adding columns : [
        - after another column // done;
        - before // not working
    ]
]

packages: [
    - socialite = [
        - github : supported;
        - dribbble : not supported;
    ]

    - 
]

Models: [
    - EmailVerification: User implements MustVerifyEmail
]

Digging Deeper: [
    - Notifications: [
        - LoginNotification
    ]
]

DesignPattern: [
    - Repository & RepositoryInterface
]

Traits: [
    - create trait to get table name and column names dynamically and help you to change the returned column names;
]

Blade: [
    - create one folder has one (index, create, edit) file to all models data shown dynamically;
]
