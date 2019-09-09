## Registering manually new users

I think you want to do this once-off, so there is no need for something fancy like creating an Artisan command etc. I would suggest to simply use *php artisan tinker* (great tool!) and add the following commands per user:

```
$user = new App\Models\User();
$user->password = Hash::make('admin');
$user->username = 'admin';
$token = Str::random(60);
$user->api_token = hash('sha256', $token);

$user->save();

```