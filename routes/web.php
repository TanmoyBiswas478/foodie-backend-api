use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/{any?}', function ($any = null) {
    // Agar koi path nahi diya toh default 'home' folder lenge
    $path = empty($any) ? 'home/index.html' : trim($any, '/') . '/index.html';
    
    $fullPath = public_path($path);

    if (File::exists($fullPath)) {
        return File::get($fullPath);
    }
    
    // Fallback agar specific file na mile toh home page dikhayega
    $fallback = public_path('home/index.html');
    if (File::exists($fallback)) {
        return File::get($fallback);
    }

    return view('welcome');
})->where('any', '.*');