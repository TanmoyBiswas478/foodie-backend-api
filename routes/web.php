use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function ($any = null) {
    // Agar koi specific file public folder mein milti hai toh serve karo
    $path = public_path($any);
    if (!empty($any) && file_exists($path) && !is_dir($path)) {
        return response()->file($path);
    }

    // Fallback: Agar home folder mein index.csr.html hai
    $homePath = public_path('home/index.csr.html');
    if (file_exists($homePath)) {
        return response()->file($homePath);
    }

    // Agar kuch na mile toh Laravel ka default welcome page dikhao taaki 404 na aaye
    return view('welcome');
})->where('any', '.*');