<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\VisitorContacted;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    public function index()
    {
        $categories = Category::paginate(8);
        return view("Contact.index", [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|max:64',
            'phone'     => 'required|digits:10',
            'email'     => 'nullable|email',
            'message'   => 'nullable|max:1024',
            'purpose'   => 'required|min:4|max:32',
        ]);

        if ($email = env('ADMIN_EMAIL')) {
            Mail::to($email)->send(new VisitorContacted($validated));
        }

        return redirect()->route('thankyou');
    }

    public function thankYou()
    {
        $categories = Category::paginate(8);
        return view('Contact.thankYou', [
            'categories' => $categories,
        ]);
    }
}
