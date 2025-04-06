<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccountType;
use App\Models\Branch;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function index()
    {
        $accounts = User::query()
            ->select('a.name', 'b.type', 'a.email','a.idstat')
            ->from('sp_account as a')
            ->leftJoin('sp_accounttype as b', 'a.idacctype', '=', 'b.id')
            ->orderBy('a.name', 'asc')
            ->paginate(10);

            $startRow = ($accounts->currentPage() - 1) * $accounts->perPage() + 1;
            $accountTypes = AccountType::all();
            $branches = Branch::all();



        return view('accounts.index', ['accounts' => $accounts,'startRow' => $startRow,
        'accountTypes' => $accountTypes, 'branches' => $branches]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
