<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request->content
        ]);

        session()->flash('success', '发布成功！');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        try {
            $this->authorize('destroy', $status);
        } catch (AuthorizationException $e) {
            return abort(403, '无权访问');
        }
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
