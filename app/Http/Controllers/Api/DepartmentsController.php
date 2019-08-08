<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function index() {
        return $this->response->array(Department::all()->toArray());
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'intro' => 'required|max:255'
        ]);

        $department = new Department;
        $department->name = $request->name;
        $department->introduction = $request->intro;
        $department->save();

        return $this->response->array($department->toArray());
    }

    public function update(Department $department, Request $request) {
        $request->validate([
            'name' => 'required|string',
            'intro' => 'required|string|max:255'
        ]);

        $department->name = $request->name;
        $department->introduction = $request->intro;
        $department->save();

        return $this->response->array($department->toArray());
    }

    public function delete(Department $department) {
        if (!$department->users->isEmpty()) {
            return $this->response->errorBadRequest('该部门尚有成员, 请删除后再执行操作');
        }

        $department->delete();

        return $this->response->noContent();
    }
}
