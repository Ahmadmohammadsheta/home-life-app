project name: home-life-app

PHP: [
    - Nesting inline if-else statements working
    return request()->wantsJson() ? response()->json($data) :
            (
                $data->parent_id == 0 ? redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']) :
                redirect()->route($this->uriRoute.'.show', ['category' => $data->parent_id])->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح'])
            );

    - all swith cases working 
    switch (true) {
        case (request()->wantsJson()):
            $return = response()->json($data);
            break;
        case ($data->parent_id > 0):
            $return = redirect()->route($this->uriRoute.'.show', ['category' => $data->parent_id])->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);
            break;
        default:
            $return = redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']);
    }
    return $return;
    - (this value not found ?? will return the side value (and (??) meaning (? null :))) if value == null
    - (this value not found ?: will return the side value (and (?:) meaning (? true :))) if value return true else return another side value

    - $slug = request()->merge([
        'slug' => Str::slug(request()->name)
     ]);

     - !(strtolower($value) == 'laravel')  // it's meaning if the condition not 
]

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

Laravel helper methods: [
    - Route::currentRouteName()
    - request()->route()->
    - $id = (request()->route('category'));
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
        - $table->foreignId('parent_id_id'->constrained('categories', 'id');
        - $table->foreignId('parent_id')->nullable(must be before any another modifier)->constrained('categories', 'id')
             ->nullOnDelet(or)->cascadeOnDelete(or)->restrictOnDelete();
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
    - public function __construct(array $attributes = array())
        {
            $this->setRawAttributes(array(
            'user_id' => auth()->id()), true);
            parent::__construct($attributes);
        }
    
]

Digging Deeper: [
    - Notifications: [
        - LoginNotification
    ]
]

DesignPattern: [
    - Repository & RepositoryInterface
    - Service Class
]

Traits: [
    - create trait to get table name and column names dynamically and help you to change the returned column names;
]

Blade: [
    - create one folder has one (index, create, edit, show, delete) file to all models data shown dynamically;
    - @if (Route::currentRouteName() === 'home')
     @endif
    - request()->route('category.id')
    - @if (\View::exists("$tableName.index")) @include("$tableName.index") @endif
    - includeif()
    - Str::contains($cloumnName, '_id')
    - @includeIf("$tableName.show", ['page' => 'name'])
    - @yeild("name", ['page' => 'name'])
    - @section('page-header', {{ __(ucfirst($tableName)) }})
    - @checked($$modelObjectName->$cloumnName === false)
    - @selected($value->id == $$modelObjectName->$cloumnName)
    - old($cloumnName, defaultValue)
    - <x-error column="{{ $cloumnName }}" /> if attribute use {{  }}
    - <x-error :name="$cloumnName" /> if :attribute don't use {{  }}
]

Request: [
    - messages ['unique' => 'The value of (:attribute) is exists'], // (:attribute) as avariable to get the attribut name
    - custom rule by a Closure function ,
                function ($attribute, $value, $fail) {
                    !strtolower($value) == 'laravel' ?: $fail($attribute, 'This name is not allowed');
                }
    - create app/Rule/Filter.php (custom Rule)
]

Unit Test [
    - Category CRUD tests are success;
]

Component: [
]
        
