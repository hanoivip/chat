<?php
namespace Hanoivip\Chat\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function messages(Request $request)    
    {
        return view('hanoivip::admin.messages');
    }
}