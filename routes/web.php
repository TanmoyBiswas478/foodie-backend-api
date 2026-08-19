use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// 1. Agar koi seedha main URL khole toh 'home/index.html' dikhaye
Route::get('/', function () {
    $path = public_path('home/index.html');
    if (File::exists($path)) {
        return File::get($path);
    }
    return view('welcome');
});

// 2. Agar koi sub-page khole (jaise /login, /dashboard, /admin) toh us naam ka folder dhoondh kar uska index.html khol de
Route::get('/{any?}', function ($any) {
    // Agar path ke aage slash ho toh use hata dein
    $any = trim($any, '/');
    
    // Check karo kya us naam ka folder public folder mein hai aur uske andar index.html hai?
    $path = public_path($any . '/index.html');
    
    if (File::exists($path)) {
        return File::get($path);
    }
    
    // Agar koi aesa route na mile, toh wapas home page par bhej do
    $fallback = public_path('home/index.html');
    if (File::exists($fallback)) {
        return File::get($fallback);
    }

    return view('welcome');
})->where('any', '.*');