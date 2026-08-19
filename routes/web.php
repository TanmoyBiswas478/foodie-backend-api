use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function () {
    // Check karo ki main index.html kahan rakhi hai
    $path = public_path('index.html');
    
    if (!file_exists($path)) {
        // Agar browser folder ke andar ho
        $path = public_path('browser/index.html');
    }
    
    if (file_exists($path)) {
        return response()->file($path);
    }

    return response('Main index.html not found in public directory!', 404);
})->where('any', '.*');