use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/{any?}', function ($any = null) {
    $slug = empty($any) ? 'home' : trim($any, '/');
    
    // Yahan hum index.csr.html target kar rahe hain
    $path = public_path($slug . '/index.csr.html');
    
    if (File::exists($path)) {
        return File::get($path);
    }
    
    $fallback = public_path('home/index.csr.html');
    if (File::exists($fallback)) {
        return File::get($fallback);
    }

    return response('Page not found!', 404);
})->where('any', '.*');