<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class TaskController extends Controller
{

    public function add_task(Request $request)
    {
        // Yönetici ise ekleyebilir
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $user = User::where('token', $token)->first();
        if (!$user) {
            return response()->json(['error' => 'Geçersiz token.'], 401);
        } else if ($user->status == 2) { // User ise
            return response()->json(['error' => 'Sadece Admin Görev Ekleyebilir']);
        }

        $request->merge([
            'status' => 0
        ]);
        $task = Tasks::create($request->post());

        // E-posta gönderme
        Mail::send('task_created', ['task' => $task], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Görev Oluşturuldu');
        });

        return response()->json([
            'title' => $task->title,
            'content' => $task->content,
            'task_time' => $task->task_time,
            'status' => $task->status,
        ], 200);
    }

    public function update_task(Request $request)
    {
        $token = str_replace('Bearer ','',$request->header('Authorization'));
        $user = User::where('token',$token)->first();
        if (!$user)
        {
            return response()->json(['error' => 'Geçersiz token.'], 401);
        }
        if ($user->status == 2) // User ise sadece statu guncelleyecek
        {
            $task = Tasks::findOrFail($request->id);
            if (!$task)
            {
                return response()->json(['error' => 'Boyle Bir Gorev Bulunamadi ']);
            }

            $task->status = $request->status;
            $task->save();
            return response()->json([
                'message' => 'User Oldugunuz Icin Sadece Statu Guncellendi ',
                'title' => $task->title,
                'content' => $task->content,
                'task_time' => $task->task_time,
                'status' => $task->status,

            ]);
        }

        $task = Tasks::whereId($request->id)->first();
        if (!$task)
        {
            return response()->json(['error' => 'Boyle Bir Gorev Bulunamadi ']);
        }
        $request->merge([
            'status' => $request->status
        ]);
        $task->update($request->post());
        return response()->json([
            'message' => 'Guncellendi ',
            'title' => $task->title,
            'content' => $task->content,
            'task_time' => $task->task_time,
            'status' => $task->status,
        ]);

    }

    public function delete_task(Request $request)
    {
        $token = str_replace('Bearer ','',$request->header('Authorization'));
        $user = User::where('token',$token)->first();
        if (!$user)
        {
            return response()->json(['error' => 'Geçersiz token.'], 401);
        }
        else if ($user->status == 2) // User ise sadece statu guncelleyecek
        {
            return response()->json(['error' => 'User Oldugunuz Icin Silme Islemi Yapamazsiniz ',]);
        }
        $task = Tasks::findOrFail($request->id);
        if (!$task)
        {
            return response()->json(['error' => 'Boyle Bir Gorev Bulunamadi ']);
        }
        $task->delete();
        return response()->json(['message' => 'Silindi']);

    }



}
