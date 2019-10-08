<?php

namespace App\Http\Controllers\Api\V1;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Department::with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {

        $path = $request->file('logo')->store('logo');
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->logo = $path;
        $department->push();

        if($request->users){
            $users = json_decode($request->users);
            Department::find($department->id)->user()->attach($users);
        }

        return $department;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Department::with('user')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'logo' => 'image|required'
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return '';
    }
}
