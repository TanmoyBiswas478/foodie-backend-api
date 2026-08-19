use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function ($any = null) {
    // Agar koi path nahi diya toh 'home' man lo
    $folder = empty($any) ? 'home' : trim($any, '/');
    
    // Alag-alag paths check karte hain
    $path1 = public_path($folder . '/index.html');
    $path2 = public_path('browser/' . $folder . '/index.html'); // Agar angular 'browser' folder mein build hua ho

    if (file_exists($path1)) {
        return response()->file($path1);
    }
    
    if (file_exists($path2)) {
        return response()->file($path2);
    }

    // Agar kahin nahi mili, toh screen par paths dikha do taaki error pakad mein aaye
    return response("Debug Info: <br> Tried path 1: " . $path1 . "<br> Tried path 2: " . $path2 . "<br> Public path root: " . public_path(), 404);
})->where('any', '.*');