[![Build Status](https://travis-ci.org/llwebsol/rAPId.svg?branch=master)](https://travis-ci.org/llwebsol/rAPId)
[![Latest Stable Version](https://poser.pugx.org/llwebsol/rapid/v/stable)](https://packagist.org/packages/llwebsol/rapid)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/llwebsol/rAPId/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/llwebsol/rAPId/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/llwebsol/rAPId/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[![Total Downloads](https://poser.pugx.org/llwebsol/rapid/downloads)](https://packagist.org/packages/llwebsol/rapid)
[![License](https://poser.pugx.org/llwebsol/rapid/license)](https://packagist.org/packages/llwebsol/rapid)

# rAPId
a simple and minimalist framework for php APIs

## Getting Started
Add to your composer.json

    "require": {
        "llwebsol/rapid": "^2.0"
    },

    "scripts": {
        "post-update-cmd": "vendor/bin/rAPId"
    }

Now run `composer update` and the necessary files should be automatically added to your projects root directory.

Add a new file to the new `Controllers` directory that was added (it may be in src/Controllers)

### Example default controller
**(src/Controllers/Main.php)**:
```
    <?php

    namespace YourProject\Controllers;

    use rAPId\Foundation\Controller;

    class Main implements Controller
    {
        /**
         * @return mixed
         */
        public function index(){

        }
    }
```

Until you add another controller or method, all routes will point to the `index` method in your Main controller

Next update your rAPIdConfig.php

```
       'default_controller' => YourProject\Controllers\Main::class,
```


## Adding Routes

Routes can be added to your project by adding new controllers and new controller methods.

Example:
if you navigate to `http://www.your-project-url.com` the Main::index() function will fire.

If you were to add the function `doSomething()` do your main controller, then navigate to
`your-project-url/do-something` (or `your_project_url/do_something` if you prefer underscores)

You could also add new routes by adding a new controller

example:
**(src/Controllers/SomethingElse.php)**
```
<?php
    namespace YourProject\Controllers;

    use rAPId\Foundation\Controller;

    class SomethingElse implements Controller
    {
        public function index(){
            return 'You are in the Index';
        }

        public function anotherThing(){
            return 'You are in Another Thing';
        }

    }
```

Now navigating to `http://www.your-project-url.com/something-else` will render "You are in the Index"

while navigating to `http://www.your-project-url.com/something-else/another-thing/` will render "You are in Another Thing"


## Input

You can specify input parameters in your public controller methods.

For example, if you were to add the following function to `YourProject\Controllers\SomethingElse`:
```
    public function getData($a_var = 'Not Defined', $another_var = 'Not Defined'){
        return [
            'A Var' => $a_var,
            'Another Var' => $another_var
        ];
    }
```

#### There are 3 ways to receive input.

#### 1:
You can receive data directly through the url:

`http://www-your-project-url.com/something-else/get-data/11/76`
```
{
    "A Var": 11,
    "Another Var": 76
}
```

---

#### 2:
You can receive data through query parameters (through a GET request only)

`http://www-your-project-url.com/something-else/get-data?another_var=76&a_var=11`
```
{
    "A Var": 11,
    "Another Var": 76
}
```

**Notice** the order doesn't matter, but the parameters will be mapped to their names in the function. If your query string contains a key that is not definied in your function, it will be ignored

`http://www-your-project-url.com/something-else/get-data?another_var=76&an_undefined_var=11`
```
{
  "A Var": "Not Definied",
  "Another Var": 76
}
```

---

#### 3:
You can receive data through POST params

*example:*

a POST request to `http://www-your-project-url.com/something-else/get-data`

with the parameters `['a_var' => 11, 'another_var' => 76]`

will output:
```
{
    "A Var": 11,
    "Another Var": 76
}
```

Similar to a GET request with query parameters, undefined parameter keys will be ignored

---

#### Notes

- You May mix url parameters with GET or POST parameters...although you probably shouldn't
    - `http://www-your-project-url.com/something-else/get-data/76?a_var = 11` will pass `$a_var = 11` to the function, and pass the next open parameter the value 76.
        ```
        {
            "A Var": 11,
            "Another Var": 76
        }
        ```
        So the same url without the query string would pass `$a_var = 76` to the function
        ```
        {
            "A Var": 76,
            "Another Var": "Not Definied"
        }
        ```
    - This is the same for POST parameters
- The query string will be ignored for POST requests
    - So a POST request to `http://www-your-project-url.com/something-else/get-data?a_var=11&another_var=76` without any data in the POST will output:
     ```
     {
         "A Var": "Not Definied",
         "Another Var": "Not Defined"
     }
     ```

## Output

Anything that you return from a controller will be serialized and returned to the user with the correct header

If nothing is returned from your controller method, then nothing will be output in this way.
If you wish to serve an image, handle outputting that image yourself, and don't return anything from your controller

The type of serialized output that your API returns is determined by the `output_serializer` variable in your `rAPIdConfig.php`

Json and XML are currently supported. If you wish to output some other kind of data, you can write your own serializer that implements `rAPId\Data\Serialization\Serializer`, then feel free to submit a pull request!
