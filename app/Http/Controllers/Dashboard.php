<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    //
    public function notifications(): \Illuminate\Http\JsonResponse
    {
        
       return response()->json(auth()->user()->unreadNotifications);
    }
    public function markNotification(Request $request): \Illuminate\Http\JsonResponse
    {

        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();
        
        return response()->json(true,200);
    }
}
