use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/{any?}', function ($any = null) {
    // Agar koi path nahi diya toh default 'home' folder lenge
    $slug = empty($any) ? 'home' : trim($any, '/');
    
    // Path banayenge jaise public/home/index.html ya public/login/index.html
    $path = public_path($slug . '/index.html');
    
    if (File::exists($path)) {
        return File::get($path);
    }
    
    // Agar exact match na mile toh home page dikha do
    $fallback = public_path('home/index.html');
    if (File::exists($fallback)) {
        return File::get($fallback);
    }

    return response('Page not found!', 404);
})->where('any', '.*');