    <?php

    use Illuminate\Support\Facades\Route;
    use App\Models\Paint;
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/my-page', function () {
        $paints = Paint::all(); // Получение всех картин из базы данных
        return view('index', compact('paints')); // Передача данных в представление
    });


    Route::get('/paints', [App\Http\Controllers\PaintController::class, 'index'])->name('paints.index');
    Route::get('/paints/create', [App\Http\Controllers\PaintController::class, 'create'])->name('paints.create');
    Route::post('/paints', [App\Http\Controllers\PaintController::class, 'store'])->name('paints.store');
    Route::get('/paints/trashed', [App\Http\Controllers\PaintController::class, 'trashed'])->name('trashed');
    Route::post('/paints/{id}/restore', [App\Http\Controllers\PaintController::class, 'restore'])->name('paints.restore');
    Route::delete('/paints/{id}/force-delete', [App\Http\Controllers\PaintController::class, 'forceDelete'])->name('paints.forceDelete');
    Route::get('/paints/{paint}', [App\Http\Controllers\PaintController::class, 'show'])->name('paints.show');
    Route::get('/paints/{paint}/edit', [App\Http\Controllers\PaintController::class, 'edit'])->name('paints.edit');
    Route::put('/paints/{paint}', [App\Http\Controllers\PaintController::class, 'update'])->name('paints.update');
    Route::delete('/paints/{paint}', [App\Http\Controllers\PaintController::class, 'destroy'])->name('paints.destroy');

