<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class ContactController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
    }


    public function index()
    {
        $contacts = $this->database->getReference($this->tablename)->getValue();
        return view('firebase.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('firebase.contact.create');
    }

    public function store(Request $request)
    {
        $postData = [
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return redirect('contacts')->with('status', 'Contact Added Successfully');
        } else {
            return redirect('contacts')->with('status', 'Contact Added Failed');
        }
    }

    public function register()
    {
        return view('firebase.contact.register');
    }

    public function storeMember(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            return redirect('register')->with('status', 'Register Failed! Password and confirmPassword is different.');
        }
        $postData = [
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return redirect('contacts')->with('status', 'Register Successfully');
        } else {
            return redirect('contacts')->with('status', 'Register Failed');
        }
    }
}
