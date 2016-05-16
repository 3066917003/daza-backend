<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class GroupController extends Controller
{

    public function __construct()
    {
        // 执行 auth 认证
        $this->middleware('auth', [
            'except' => [
                'index',
                'show'
            ]
        ]);
    }

    public function index(Request $request)
    {
        $query = Group::orderBy('created_at', 'asc');
        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        return $this->failure();
    }

    public function show(Request $request, $group_id)
    {
        $request->merge(['group' => $group_id]);
        $this->validate($request, ['group' => 'exists:groups,id']);

        $data = Group::find($group_id);
        return $this->success($data);
    }

    public function update(Request $request)
    {
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

    public function join(Request $request, $group_id)
    {
        $request->merge(['group' => $group_id]);
        $this->validate($request, ['group' => 'exists:groups,id']);

        $group_member = GroupMember::withTrashed()->firstOrCreate([
            'user_id'  => Auth::id(),
            'group_id' => $group_id
        ]);

        if ($group_member) {
            $group_member->restore();
            return $this->success();
        }

        return $this->failure();
    }

}
