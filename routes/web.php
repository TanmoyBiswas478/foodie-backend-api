use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $path = public_path('home/index.html');
    if (file_exists($path)) {
        return response()->file($path);
    }
    return 'Home index.html not found at: ' . $path;
});

Route::get('/{any}', function ($any) {
    $path = public_path($any . '/index.html');
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
})->where('any', '.*');