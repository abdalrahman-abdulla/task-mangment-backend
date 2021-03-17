<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments=Department::all();
            return response()->json($departments, 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $departments=Department::findOrFail($id);
            return response()->json($departments, 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function store(Request $req)
    {
        try {
            $this->validate($req , [
                'name'=>'required|unique:departments',
            ]);
            $department=Department::create([
                'name' => $req['name'],
            ]);
            return response()->json($req['name'] . ' has been added', 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function update(Request $req,$id)
    {
        try {
            $this->validate($req , [
                'name'=>'required|unique:departments,name,'. $id .",id",
            ]);
            $department=Department::findOrFail($id);
            $department->update([
                'name' => $req['name'],
            ]);
            return response()->json($department->name . ' has been updated', 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            Department::findOrFail($id)->delete();
            return response()->json(true, 200);
        } catch (Exception $exception) {
            return $this->responseError(null, 'something goes wrong: ' . $exception->getMessage());
        }
    }
}
