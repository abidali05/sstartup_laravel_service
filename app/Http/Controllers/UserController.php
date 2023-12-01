<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $_service = null;
    private $_directory = 'auth/pages/users';
    private $_route = 'users';

    public function __construct()
    {
        $this->_service = new UserService();
    }


    public function index()
    {
        $data['all'] = $this->_service->index();
        return view($this->_directory . '.all', compact('data'));
    }


    public function create()
    {
        return view($this->_directory . '.create');
    }


    public function store(UserRequest $request)
    {
        try {
            $this->_service->store($request->validated());
            return redirect()->route($this->_route . '.index');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->_route . '.index')->with('error', 'Something went wrong.');
        }
    }


    public function show($id)
    {
        $data = $this->_service->show($id);
        return view($this->_directory . '.show', compact('data'));
    }


    public function profile()
    {
        $data = Auth::user();
        return view($this->_directory . '.show', compact('data'));
    }


    public function edit($id)
    {
        $data = $this->_service->show($id);

        if ($data == null) {
            abort(404);
        }

        return view($this->_directory . '.edit', compact('data'));
    }


    public function editProfile()
    {
        $data = Auth::user();
        return view($this->_directory . '.edit_my_profile', compact('data'));
    }


    public function updateMyProfile(UserRequest $request)
    {
        $this->_service->update(Auth::id(), $request->validated());
        return redirect()->route('myprofile');
    }


    public function update(UserRequest $request, $id)
    {
        $this->_service->update($id, $request->validated());
        return redirect()->route($this->_route . '.index');
    }


    public function destroy($id)
    {
        $this->_service->destroy($id);
        return redirect()->route($this->_route . '.index');
    }
}
