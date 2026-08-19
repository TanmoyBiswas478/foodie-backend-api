use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/{any?}', function ($any = null) {
    $path = empty($any) ? 'home/index.html' : trim($any, '/') . '/index.html';
    $fullPath = base_path('public/' . $path);

    if (File::exists($fullPath)) {
        return File::get($fullPath);
    }
    
    $fallback = base_path('public/home/index.html');
    if (File::exists($fallback)) {
        return File::get($fallback);
    }

    return view('welcome');
})->where('any', '.*');