<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $this->custom_authorize('browse_roles');
    //     return view('administrations.people.browse');
    // }

    public function list(){

        $search = request('search');
        $paginate = request('paginate') ?? 10;

        $data = Role::when($search, function($query, $search) {
                            $query->where('name', 'like', "%{$search}%")
                                  ->orWhere('display_name', 'like', "%{$search}%");
                            if(is_numeric($search)) {
                                $query->orWhere('id', $search);
                            }
                        })
                        ->when(Auth::user()->role_id != 1, fn($q) => $q->where('id', '!=', 1))
                        ->orderBy('id', 'DESC')->paginate($paginate);

        return view('vendor.voyager.roles.list', compact('data'));
    }
}
