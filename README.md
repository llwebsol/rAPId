# rAPId
a simple and minimalist framework for php APIs

## Getting Started
Add to your composer.json

    "require": {
        "llwebsol/rapid": "dev-master"
    },

    "scripts": {
        "post-update-cmd": "vendor/bin/rAPId"
    }

Now after running `composer update` the necessary files should be automatically added to your projects root directory.

Add a new file to the new `Controllers` that was added (it may be in src/Controllers)

### Example default controller
**(src/Controllers/Default.php)**:
```
    <?php

    namespace YourProject\Controllers;

    class Default implements rAPId\Foundation\Controller
    {
        /**
         * @return mixed
         */
        public function index(){

        }
    }
```

Until you add another controller or method, all routes will point to the `index` method in your default controller

Next update your rAPIdConfig.php

```
       define('DEFAULT_CONTROLLER', YourProject\Controllers\Default::class);
```


## Adding Routes

Routes can be added to your project by adding new controllers and new controller methods.

Example:
if you navigate to `http://www.your-project-url.com` the Default::index() function will fire.

If you were to add the function `doSomething()` do your default controller, then navigate to
`your-project-url/do-something` (or `your_project_url/do_something` if you prefer underscores)

You could also add new routes by adding a new controller

example:
**(src/Controllers/SomethingElse.php)**
```
<?php
    namespace YourProject\Controllers;

    class SomethingElse implements rAPId\Foundation\Controller
    {
        public function index(){
            echo 'You are in the Index';
        }

        public function anotherThing(){
            echo 'You are in Another Thing';
        }

    }
```

Now navigating to `http://www.your-project-url.com/something-else` will render "You are in the Index"

while navigating to `http://www.your-project-url.com/something-else/another-thing/` will render "You are in Another Thing"


## Input

You can specify input parameters in your public controller methods
for example, if you were to add the following function to `YourProject\Controllers\SomethingElse` from the previous example:
```
    public function getData($a_var = 'Not Defined', $another_var = 'Not Defined'){
        echo "A Var: $a_var, Another Var: $another_var";
    }
```

#### There are 3 ways to receive input.

#### 1:
You can receive data directly through the url:

`http://www-your-project-url.com/something-else/get-data/11/76`
will output  "A Var: 11, Another Var: 76"

#### 2:
You can receive data through query parameters (through a GET request only)
`http://www-your-project-url.com/something-else/get-data?another_var=76&a_var=11`
will output  "A Var: 11, Another Var: 76"

**Notice** the order doesn't matter, but the parameters will be mapped to their names in the function. If your query string contains a key that is not definied in your function, it will be ignored

`http://www-your-project-url.com/something-else/get-data?another_var=76&an_undefined_var=11`
will output  "A Var: Not Defined, Another Var: 76"

#### 3:
You can receive data through POST params

a POST request to `http://www-your-project-url.com/something-else/get-data`
with the parameters `['a_var' => 11, 'another_var' => 76]`
will output  "A Var: 11, Another Var: 76"

Similar to a GET request with query parameters, undefined parameter keys will be ignored



#### Notes

- You May mix url parameters with GET or POST parameters...although you probably shouldn't
    - `http://www-your-project-url.com/something-else/get-data/76?a_var = 11` will pass `$a_var = 11` to the function, and pass the next open parameter the value 76. So the same url without the query string would pass `$a_var = 76` to the function
    - This is the same for POST parameters
- The query string will be ignored for POST requests
    - So a POST request to `http://www-your-project-url.com/something-else/get-data?a_var=11&another_var=76` without any data in the POST will output "A Var: Not Defined, Another Var: Not Defined";