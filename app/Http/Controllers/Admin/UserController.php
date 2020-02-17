<?php

namespace FDA\Http\Controllers\Admin;

use FDA\User;
use FDA\Filters\UserFilter;
use Illuminate\Http\Request;
use FDA\Http\Controllers\Controller;
use FDA\Http\Requests\CreateUserRequest;
use FDA\Http\Requests\UpdateUserRequest;
use FDA\Department;
use FDA\Exports\ExportUsers;
use FDA\Imports\ImportUser;
use Maatwebsite\Excel\Facades\Excel;
use FDA\RoleUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilter $filter)
    {
        $role = RoleUser::find(auth()->user()->roleUser->id);

        if($role->id === 1){ //login user is super admin
            $users = User::with(['department', 'roleUser'])->filter($filter)->where('role','<>',99)->orderBy('id','desc')->paginate(20);
        }else{
            $users = User::with(['department', 'roleUser'])->filter($filter)->where([
                ['role', '<>', 99],
                ['role_id', $role->id],
                ['department_id', auth()->user()->department_id],
            ])->orderBy('id', 'desc')->paginate(20);
        }
        // $users = User::filter($filter)->where('role','<>',99)->orderBy('id','desc')->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = config('form.roles');
        $role = RoleUser::find(auth()->user()->roleUser->id);
        if($role->id === 1){
            $departments = Department::all();
            $roles = RoleUser::all();
        }else{
            $departments = Department::where([
                ['id', auth()->user()->department_id]
            ])->get();
            $roles = RoleUser::where([
                ['id', auth()->user()->id]
            ])->get();
        }

        // dd(auth()->user()->department_id);
        return view('admin.users.create', compact('roles','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        $data['password'] = bcrypt(request('password'));
        $data['applicant_name'] = "admin";
        $data['applicant_nrc'] = "a/b(c)123456";
        $data['is_active'] = 1;
        $data['role'] = 1;

        User::create($data);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \FDA\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \FDA\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // $roles = config('form.roles');
        $role = RoleUser::find(auth()->user()->roleUser->id);
        if($role->id === 1){

            $departments = Department::all();

            $roles = RoleUser::all();

        }else{

            $departments = Department::where([
                ['id', auth()->user()->department_id]
            ])->get();
            $roles = RoleUser::where([
                ['id', auth()->user()->role_id]
            ])->get();

        }

        return view('admin.users.edit', compact('user', 'roles','departments'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \FDA\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ((auth()->user()->role_id == 1) || $user->id == auth()->user()->id) {

            $data = $request->validated();
            unset($data['password']);

            if ($password = request('password')) {
                $data['password'] = bcrypt($password);
            }

            $user->update($data);

            return redirect()->route('admin.users.index')->with("success", "Ok, successfully updated.");
        }
        return redirect()->route('admin.users.index')->with("warning", "You are not authorize to update.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \FDA\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(auth()->user()->id <> 1)
        {
            return redirect()->route("admin.users.index")->with("warning", "Yor are not authorized to delete.");
        }
        // $user->delete();

        return back();
    }

    public function getCompanyRegId(Request $request)
    {

        $user = User::select('company_registration_no')->find($request->user_id);
        return response()->json($user);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new ExportUsers, 'users.xlsx');
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        Excel::import(new ImportUser, request()->file('file'));
            
        return back();
    }
}
