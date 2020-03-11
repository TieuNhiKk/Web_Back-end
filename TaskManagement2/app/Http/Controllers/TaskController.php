<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{


    public function home()
    {
        return view('task.welcome');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')->get();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = request('title');
        $content = request('content');
        $due_date = request('due_date');

        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $type = $file->getClientOriginalExtension();
            $data = file_get_contents($file->getpathname());
            $avatar = "data:image/$type;charset=utf-8;base64," . base64_encode($data);
            DB::table('tasks')->insert(
                [
                    'title' => $title,
                    'content' => $content,
                    'avatar' => $avatar,
                    'due_date' => $due_date
                ]
            );
        } else {
            DB::table('tasks')->insert(
                [
                    'title' => $title,
                    'content' => $content,
                    'due_date' => $due_date
                ]
            );
        }

        return redirect('tasks/create')->with('create_success', "Thêm task thành công");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = DB::table('tasks')->where('id', $id)->first();
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = DB::table('tasks')->where('id', $id)->first();
        return view('task.edit', compact('task'));
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

        $title = $request->title;
        $content = $request->content;
        $due_date = $request->due_date;
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $type = $file->getClientOriginalExtension();
            $data = file_get_contents($file->getpathname());
            $avatar = "data:image/$type;charset=utf-8;base64," . base64_encode($data);
            DB::table('tasks')->where('id', $id)->update(
                [

                    'title' => $title,
                    'content' => $content,
                    'avatar' => $avatar,
                    'due_date' => $due_date
                ]
            );
        } else {
            DB::table('tasks')->where('id', $id)->update(
                [
                    'title' => $title,
                    'content' => $content,
                    'due_date' => $due_date
                ]
            );
        }
        return redirect()->route('task.edit', ['id' => $id])->with('update_success', 'Chỉnh sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tasks')->where('id', $id)->delete();
        return redirect('task/index');
    }

    public function uploadImg($file)
    {


        $type = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (in_array(strtolower($type), ['png', 'jpg', 'jpeg', 'gif'])) {
            $data = file_get_contents($file['tmp_name']);
            $base64 = "data:image/$type;charset=utf-8;base64," . base64_encode($data);
            return  $base64;
        }
    }
}
