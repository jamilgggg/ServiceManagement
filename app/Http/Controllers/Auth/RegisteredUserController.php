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
            'a.profile_picture',
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
                'profile_picture' => ['nullable','image','mimes:jpg,jpeg,png','max:2048']
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

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $path;
                $user->save();
            }

           $user->branches()->attach($request->branches);
    
            return redirect()->back()->with('success', 'Account Added Succesfully');
        }catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Account Creation Error: ' . $e->getMessage());
            return redirect()->back()
            ->withInput($request->except('profile_picture')) 
            ->with('form_errors', $e->errors())
            ->with('mode', 'create')
            ->with('error', 'Validation failed. Please check the form.');
        }

    }

    public function updateAccounts(Request $request, User $user){
        try{
            $request->validate([
                'empid' => ['required', 'string', 'regex:/^\d+$/','max:5'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:sp_account,email,' . $user->id],
                'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                'user_contactnum' => ['required', 'string', 'max:50'],
                'idgender' => ['required'],
                'idacctype' => ['required'],
                'idemailstat' => ['required'],
                'branches' => ['required'],
                'idstat' => ['required'],
                'profile_picture' => ['nullable','image','mimes:jpg,jpeg,png','max:2048']
            ]);
    
            $updateData = [
                'empid' => $request->empid,
                'name' => $request->name,
                'email' => $request->email,
                'user_contactnum' => $request->user_contactnum,
                'idgender' => $request->idgender,
                'idacctype' => $request->idacctype,
                'idemailstat' => $request->idemailstat,
                'idstat' => $request->idstat,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture && \Storage::disk('public')->exists($user->profile_picture)) {
                    \Storage::disk('public')->delete($user->profile_picture);
                }
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $updateData['profile_picture'] = $path;
            }

            $user->update($updateData);

            $user->branches()->sync($request->input('branches', []));
            
            return redirect()->back()->with('success', 'Account Updated Succesfully');
        }catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Account Update Error: ' . $e->getMessage());
            return redirect()->back()
            ->withInput($request->except('profile_picture')) 
            ->with('mode', 'edit') 
            ->with('form_errors', $e->errors())
            ->with('updateValues', array_merge($request->all(), ['id' => $user->id]))
            ->with('error', 'Validation failed. Please check the form.');
        }

    }
}
