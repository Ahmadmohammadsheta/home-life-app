project name: home-life-app

PHP: [
    - Nesting inline if-else statements working
    return request()->wantsJson() ? response()->json($data) :
            (
                $data->parent_id == 0 ? redirect()->route($this->uriRoute.'.index')->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح']) :
                redirect()->route($this->uriRoute.'.show', ['category' => $data->parent_id])->with(['session' => 'success', 'message' => 'تم الاضافة بنجاح'])
            );

    - all switch cases working 
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

     - [Category::query() // to get any query you run after this lin
            Category::query();

            if ($name = $request->query('name')) {
                $query->where('name', 'LIKE', "%$name%");
            }

            if ($isParent = $request->query('is_parent')) {
                $query->whereIsParent($isParent);
            }
        ]
]

setup: [
    - composer global require laravel/installer // only install first time
    - laravel new home-life-app // (laravel new) use in every new app installing
]

routes: [
    - group
    - prefix
    - namespace
    - name : as
    - controller
    - middleware
    - resource
    - Route::put('categories/{category}/restore', 'restore')->name('categories.restore')->where('category', '\d+'); // \d its mean any digit + mean more 111111

],

Laravel helper methods: [
    - Route::currentRouteName()
    - request()->route() // return route data
    - $id = (request()->route('category'));
    - Illuminate/contracts/.... // use any interface
    - // to make the table pagination using bootstrap css because the default using tailwind
        Paginator::useBootstrapFive();

    - fill($request->all()) // to fill the object values
        ->save(); // if exist will update else will create
]

Laravel: [
        
]

AppServiceProvider : [
        [
            // to use the filter in the same request validation syntax => 'name'=> 'required|filter' // AMA custom
            Validator::extend('filter', function($attribute, $value, $params){
                return in_array($value, $params);
            }, 
        ]"The value is prohibited");

        [
            // to make the table pagination using bootstrap css because the default using tailwind
            Paginator::useBootstrapFive();
            // Paginator::defaultView('crud.pagination.custom')
        ];
    }
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
             ->nullOnDelete(or)->cascadeOnDelete(or)->restrictOnDelete();
        
        - $table->dropConstrainedForeignId('provider_id'); to drop the column with Delete       - after another column // done;
        - before // not working
        - $table->foreignId('parent_id_id'->constrained('categories', 'id');
        - $table->foreignId('parent_id')->nullable(must be before any another modifier)->constrained('categories', 'id')
             ->nullOnDelete(or)->cascadeOnDelete(or)->restrictOnDelete();
        
        - $table->dropConstrainedForeignId('provider_id'); to drop the column with the relation
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


    - من مساوئ المودل تخزين داتا العلاقات عند استخدام ويز في علاقة بيلونجس تو في الميموري مما يستهلك مساحة كبيرة من السيرفر لذلك يفضل استخدام ال جوين في المشاريع الكبيرة و ايضا يفضل عدم استخدهم ويز في ال هاز ماني
    - عند عدم استخدام ويز في علاقة بيلونجس تو فان كل لفة فورايش تقوم بريكويست جديد لذلك نستخدماها
    
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
    - old($cloumnName, defaultValue) // working only in the post
    - <x-error column="{{ $cloumnName }}" /> if attribute use {{  }}
    - <x-error :name="$cloumnName" /> if :attribute don't use {{  }}
    - {{ $data->withQueryString()->append(['column' => 'value'])->links() }} // to show the paginate links // withQueryString-> to save the search paraneter in the url when refreh page or go to an another page // ->append() to add another parameter to search url

    - {{ URL::current() }} return thr current route
    
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
        

Commands: [
    - php artisan vendor:publish --tag=laravel-pagination // to publish a copy of ogiginal pagination files in view folder
]
