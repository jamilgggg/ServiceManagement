<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\AccountBranch;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            ->select(
   'a.id',
            'a.empid',
            'a.name',
            'a.email',
            'a.idstat',
            'a.user_contactnum',
            'a.idgender',
            'a.idacctype',
            'a.idemailstat',
            'b.type')
            ->from('sp_account as a')
            ->leftJoin('sp_accounttype as b', 'a.idacctype', '=', 'b.id')
            ->orderBy('a.name', 'asc')
            ->paginate(10);

            $accountIds = $accounts->pluck('id');

            $branchMap = AccountBranch::whereIn('account_id', $accountIds)
                ->get()
                ->groupBy('account_id')
                ->map(function ($branches) {
                    return $branches->pluck('branch_id')->toArray(); // ← return array instead of string
                });

            foreach ($accounts as $account) {
                $account->branches = $branchMap[$account->id] ?? [];
            }

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

    public function addAccounts(Request $request){
        try{
            $request->validate([
                'empid' => ['required', 'string', 'regex:/^\d+$/','max:5'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required','string','min:8','regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],//alphanumeric
                'user_contactnum' => ['required', 'string', 'max:50'],
                'idgender' => ['required'],
                'idacctype' => ['required'],
                'idemailstat' => ['required'],
                'branches' => ['required'],
            ]);
    
            $user = User::create([
                'empid' => $request->empid,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_contactnum' => $request->user_contactnum,
                'idgender' => $request->idgender,
                'idacctype' => $request->idacctype,
                'idemailstat' => $request->idemailstat,
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]);
    
            $selectedBranches = $request->input('branches');
            $userId = $user->id;
    
            if ($selectedBranches) {
                foreach ($selectedBranches as $branchId) {
                    AccountBranch::create([
                        'account_id' => $userId,
                        'branch_id' => $branchId,
                    ]);
                }
            }
    
            return redirect()->back()->with('success', 'Account Added Succesfully');
        }catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Account Creation Error: ' . $e->getMessage());
            return redirect()->back()
            ->withInput()
            ->with('form_errors', $e->errors())
            ->with('mode', 'create')
            ->with('error', 'Validation failed. Please check the form.');
        }

    }

    public function updateAccounts(Request $request){
        try{
            $request->validate([
                'empid' => ['required', 'string', 'regex:/^\d+$/','max:5'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required','string','min:8','regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],//alphanumeric
                'user_contactnum' => ['required', 'string', 'max:50'],
                'idgender' => ['required'],
                'idacctype' => ['required'],
                'idemailstat' => ['required'],
                'branches' => ['required'],
            ]);
    
            $user = User::update([
                'empid' => $request->empid,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_contactnum' => $request->user_contactnum,
                'idgender' => $request->idgender,
                'idacctype' => $request->idacctype,
                'idemailstat' => $request->idemailstat,
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
            ]);
            return redirect()->back()->with('success', 'Account Added Succesfully');
        }catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Account Creation Error: ' . $e->getMessage());
            return redirect()->back()
            ->withInput()
            ->with('form_errors', $e->errors())
            ->with('error', 'Validation failed. Please check the form.');
        }

    }
}
