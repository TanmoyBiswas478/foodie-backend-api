use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function ($any = null) {
    $slug = empty($any) ? 'home' : trim($any, '/');
    
    // Alag-alag possible paths check karte hain
    $paths = [
        public_path($slug . '/index.csr.html'),
        public_path($slug . '/index.html'),
        public_path('index.csr.html'),
        public_path('index.html')
    ];

    foreach ($paths as $path) {
        if (file_exists($path) && !is_dir($path)) {
            return response()->file($path);
        }
    }

    // Agar ek bhi file nahi mili, toh debug karne ke liye yeh dikhaye ga
    return response("Frontend build files are missing inside the Docker container public/ folder. Please check if your Angular build output folders (home, login, etc.) are pushed to GitHub and not blocked by .dockerignore.", 404);
})->where('any', '.*');