<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of system roles and their assigned members.
     */
    public function index(): View
    {
        $roles = Role::with(['members.team', 'members.projects'])
            ->withCount('members')
            ->orderBy('id')
            ->get();

        return view('roles.index', [
            'roles' => $roles,
        ]);
    }
}
