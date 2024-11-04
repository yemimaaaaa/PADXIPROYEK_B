<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check()) 
        {
            if ('admin' == $role) {
                return $next($request);
            } 
        }

        abort(403);
        $pegawai = session('pegawai');
        $role = $pegawai->role->nama_role;
 
        $routes = [
            'Owner' => [
                'allowed_routes' => [
                    'dashboard',
                    'pegawai.index', 'pegawai.create', 'pegawai.show', 'pegawai.edit', 'pegawai.delete',
                    'member.index', 'member.create', 'member.show', 'member.edit', 'member.delete',
                    'produk.index', 'produk.create', 'produk.show', 'produk.edit', 'produk.delete',
                    'transaksipenjualan.index', 'transaksipenjualan.create', 'transaksipenjualan.show', 'transaksipenjualan.detail',
                    'stok.index', 'stok.create', 'stok.show', 'stok.edit', 'stok.delete',
                    'logout',
                ],
            ],
            'AdminKasir' => [
                'allowed_routes' => [
                    'dashboard',
                    'pegawai.index', 'pegawai.create', 'pegawai.show', 'pegawai.edit', 'pegawai.delete',
                    'member.index', 'member.create', 'member.show', 'member.edit', 'member.delete',
                    'produk.index', 'produk.create', 'produk.show', 'produk.edit', 'produk.delete',
                    'transaksipenjualan.index', 'transaksipenjualan.create', 'transaksipenjualan.show', 'transaksipenjualan.detail',
                    'stok.index', 'stok.create', 'stok.show', 'stok.edit', 'stok.delete',
                    // 'poin.index', 'poin.penukaran', 'poin.show', 
                    'logout',
                ],
            ],
        ];
 
        if(!isset($routes [$role])) {
            return redirect()->route('login')->with([
                'message' => 'Peran tidak dikenal!',
                'alert-type' => 'error'
            ]);
        }
 
        $currentRouteName = $request->route()->getName();
 
        if(isset($routes[$role]['allowed_routes']) && !in_array($currentRouteName, $routes[$role]['allowed_routes'])) {
            return redirect()->back()->with([
                'message' => 'Anda tidak memiliki hak akses ini!',
                'alert-type' => 'warning'
            ]);
        }
 
        return $next($request);
 
    }
}
 