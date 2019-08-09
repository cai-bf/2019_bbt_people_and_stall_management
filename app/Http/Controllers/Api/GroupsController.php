<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Group;
use Spatie\Permission\Models\Role;

class GroupsController extends Controller
{
    public function index() {
        return $this->response->array(Group::all()->toArray());
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'intro' => 'string',
            'isAdmin' => 'required|between:0,1'
        ]);

        $group = new Group;
        $group->fill($request->all());
        $group->isManager = $request->isAdmin;
        $group->save();

        Role::create(['name' => $group->name]);

        return $this->response->array($group->toArray());
    }

    public function update(Group $group, Request $request) {
        $request->validate([
            'name' => 'required|string',
            'intro' => 'string'
        ]);

        Role::where('name', $group->name)->update(['name' => $request->name]);

        $group->fill($request->all());
        $group->save();

        return $this->response->array($group->toArray());
    }

    public function delete(Group $group) {
        if (!$group->users->isEmpty())
            return $this->response->errorBadRequest('存在该管理层成员, 请先删除或转移');
        
        $group->delete();

        return $this->response->noContent();
    }
}
