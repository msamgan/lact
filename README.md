# Access controller methods directly in your frontend files.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/msamgan/lact.svg?style=flat-square)](https://packagist.org/packages/msamgan/lact)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/msamgan/lact/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/msamgan/lact/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/msamgan/lact/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/msamgan/lact/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/msamgan/lact.svg?style=flat-square)](https://packagist.org/packages/msamgan/lact)

Laravel controller
```php
use Msamgan\Lact\Attributes\Action;

class DashboardController extends Controller
{
    #[Action(method: 'get')]
    public function dashboardData(Request $request)
    {
        return User::query()
            ->when($request->has('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('q') . '%');
            })->get();
    }
}
```
Frontend JSX
```jsx
import { dashboardData } from '@actions/DashboardController';

dashboardData.call({
    param: {
        q: 'Amber',
    },
}).then(async (response) => {
    console.log(await response.json());
    /*[
        {
            "id": 2,
            "name": "Amber Miles",
            "email": "biduro@mailinator.com",
            "email_verified_at": null,
            "created_at": "2025-04-06T11:49:36.000000Z",
            "updated_at": "2025-04-06T11:49:36.000000Z"
        }
    ]*/
});
```

## Support Me

I invest a lot of resources into creating [best in class open source packages](https://msamgan.com/projects).
You can support us by [buying me a Coffee](https://ko-fi.com/msamgan)
or [sponsoring this project.](https://github.com/sponsors/msamgan).

## Pre Requirements

The following requirements should be met in order for this package to work.

- This package depends on ```fetch``` which was default after ```node 18```. **The min node version required is 18.**
- The ```route function``` from ```ziggy``` is also a dependency. It comes by default with inertia setup.
- If you are using the routes approach, the ```route``` you want to translate to action ```should have a name```.

## Installation

You can install the package via composer:

```bash
composer require msamgan/lact
```

you will also need the vite plugin.

```bash
npm i -D vite-plugin-run
```

## Setup

Then, update your application's ```vite.config.js``` file to watch for changes to your application's routes and
controllers:

```js
import {run} from "vite-plugin-run";

export default defineConfig({
    plugins: [
        // ...
        run([
            {
                name: "lact",
                run: ["php", "artisan", "lact:build-actions"],
                pattern: ["routes/**/*.php", "app/**/Http/Controllers/**/*.php"],
            },
        ]),
    ],
});
```

For convenience, you may also wish to register aliases for importing the generated files into your application:

```js
import { resolve } from 'node:path';

export default defineConfig({
    // ...
    resolve: {
        alias: {
            '@actions': resolve(__dirname, 'vendor/msamgan/lact/resources/action'),
        },
    },
});
```

## Approach One: Action Attribute
If you are using ```lact``` you don't have to crate routes, lact will take care of it for you.
All you have to do is add and ```#[Action]``` attribute to your controller method,
with a mandatory ```methods: 'get|post|...'```. 

```php
use Msamgan\Lact\Attributes\Action;

#[Action(method: 'get')]
public function dashboardData(Request $request)
{
    return User::query()
        ->when($request->has('q'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->get('q') . '%');
        })->get();
}
```
Apart from method you can also pass the following params as per your requirement in ```#[Action]```

- (string) name: name of the route.
- (array) params: array off all the url params, in same order as you want in URL.
- (array) middleware: array of all the middleware you want to apply in the route for this method.

```php
use Msamgan\Lact\Attributes\Action;

#[Action(method: 'post', params: ['user'], 'user.update', middleware: ['auth', 'verified'])]
public function update(User $user, Request $request)
{
    // process...
}

// the route for the above function will translate to
// Route::post('85906367-216d-4f44-b463-4c3508478b52/{user}', [App\Http\Controllers\DashboardController::class, 'update'])
//      ->name('user.update')->middleware(['auth','verified',])->prefix('action');
```
## Approach Two: Action Prefix

The first step will be **adding a prefix ```action``` to the ```route``` which you want to be translated into actions.**

### Add ```action``` prefix.

```php
Route::get('path', [ControllerName::class, 'functionName'])->name('route.name')->prefix('action');
```

**Caution: ones you add the prefix, the urls of the routes will be changed. In case you are using the routes directly please update those with a ```/action``` prefix.**
```
e.g., /user => /action/user
```

### Generate Definitions.
Once all the required routes are tag with the prefix, then you can generate the definition by running

```bash
php artisan lact:build-actions
```

### Usage

```jsx
import { functionName } from '@actions/ControllerName';

// ...
functionName.call({}).then(async (r) => {
    const res = await r.json()
    // process....
})

functionName.route()
// /path

functionName.route({ user: 1 })
// /path/1

functionName.route({ q: 'Amber' })
// /path?q=Amber

functionName.routeName
// 'route.name'
```

### Signatures
Following are the signatures of the functions based on the method of the route.

#### GET
```js
function({ param = {}, headers = {}, methodHead = false }) {}

//...
functionName.call({
    param: {q: 'text'},
    headers: {},
    methodHead: true // incase you just want to send a HEAD request insted of GET
}).then(async (r) => {
    const res = await r.json()
    // process....
})
```

#### POST
```js
function({ data = {}, headers = {}, param = {} }) {}

//...
functionName.call({
    data: {name: 'some-name'},
    headers: {
        Authreziation: "Barer <token>"
    },
}).then(async (r) => {
    const res = await r.json()
    // process....
})
```
In ```POST, PUT and PATCH``` we have ```data``` object.

**NOTE: Please add below meta-tag to your ```app.blade.php``` to resolve the CSRF issues for your post-routes.**
```html
<meta name="csrf" content="{{ csrf_token() }}">
```
### Closures
for Closures, the ```name of the route``` becomes the name of the calling function,
which can be imported from ```"Closures"```

```php
Route::get('dashboard-data', function () {
    return \App\Models\User::query()->get();
})->name('dashboard.data')->prefix('action');
```

```jsx
import { dashboardData } from '@actions/Closures';

//...
dashboardData.call({
    param: {
        q: 'Amber',
    },
}).then(async (r) => {
    const res = await r.json()
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [msamgan](https://github.com/msamgan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
