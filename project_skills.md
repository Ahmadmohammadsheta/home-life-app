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
],[
    - Route::currentRouteName()
    - request()->route()->
]

RouteServiceProvider : [
    - dynamic controller namespace [
        
        protected $namespace = 'App\Http\Controllers';
    
        Route::middleware('web')
            // AMA-routes controller namespace
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    ]
]

HelperServiceProvider : [
    - dynamic get tables from my DB [
        
        using Helpers/mysqlTables.php globally available
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

    - Intervention Image: [
        - version 3.4 (the latest) 07-03-2024
    ]

    - 
]

Models: [
    - [EmailVerification, resetPassword]: User implements MustVerifyEmail
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
    - create one folder has one (index, create, edit, show, delete) file to all models data shown dynamically;
    - @if (Route::currentRouteName() === 'home')
     @endif
    - request()->route('category.id')
    - @if (\View::exists("CRUD.$tableName.index")) @include("CRUD.$tableName.index") @endif
    - includeif()
    - Str::contains($column['name'], '_id')
]
