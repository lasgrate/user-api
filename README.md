## Documentation

user-api is simple application that provides an opportunity to save users, authorize them and track their actions on the site.

#### Instal project

```bash
$ git clone https://github.com/lasgrate/user-api.git 
$ composer install
$ php -S localhost:8000 -t public
```

#### API
* ##### /users
    ###### Create new user
    _example of request params_:
    ```js
    {
        nickname: "Lasgrate",
        firstname: "Andrii",
        lastname: "Dudnyk",
        age: 21,
        password: "qwerty123"
    }
    ```
    _example of response params_:
    ```js
    {
        status: 1 // or 0
    }
    ```
    
* ##### /users/session
    ###### Create user session (authorize user)
    _example of request params_:
    ```js
    {
        nickname: "Lasgrate",
        password: "qwerty123"
    }
    ```
    _example of response params_:
    ```js
    {
        status: 1 // or 0
    }
    ```
    
* ##### /users/tracking
    ###### Create user tracking data
    _example of request params_:
    ```js
    {
        source_label: "click",
    }
    ```
    _example of response params_:
    ```js
    {
        status: 1 // or 0
    }
    ```
