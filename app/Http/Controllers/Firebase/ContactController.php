<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Messaging\CloudMessage;
use SebastianBergmann\GlobalState\Snapshot;

class ContactController extends Controller
{

    public function __construct(Database $database, Messaging $messaging)
    {
        // $this->middleware('auth');
        $this->database = $database;
        $this->tablename = 'contacts';
        $this->messaging = $messaging;
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
            'device_token' => null,
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
        if ($request->device_token == '') {
            return redirect('register')->with('status', 'Register Failed! Please change browser to get device token.');
        }
        $postData = [
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'device_token' => $request->device_token,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return redirect('contacts')->with('status', 'Register Successfully');
        } else {
            return redirect('contacts')->with('status', 'Register Failed');
        }
    }

    public function sendMsg()
    {
        return view('firebase.contact.send');
    }

    public function send(Request $request)
    {
        // $query = $this->database->getReference($this->tablename)->orderByChild('device_token');
        $query = $this->database->getReference($this->tablename)->getValue();

        $firebaseToken = [];

        $n = sizeof($query);

        foreach ($query as $key => $value) {
            foreach ($value as $key => $value) {
                echo array_push($firebaseToken, $value);
                break;
            }
        }

        // $a = $query->{$key}['device_token'] ;
        // dd($a);
        // dd(count($query));
        // dd($query['-MqyaNxDiga9oWg1CEvR']['device_token']);
        // dd(getValue($query));
        // dd($firebaseToken);
        // $firebaseToken = ['eyOD5COPuSe0ProGlRyBWD:APA91bGQFDWRvVbB5sI7Kzmtr0WV4nsyL_8QtP2ksib9zXU7u7A6tGNBLlZFUuZJQjcRXzvqAEDMuc0yMRL5x3b48tJGwzfYkjS4MbOoDSA7SZUIVn5LQLENkSX4-LWTYNkTE8aPOYr4'];

        $SERVER_API_KEY = 'AAAAuR5Zp74:APA91bEX5iYcNRUUEDC74xxGvMGBjAgD3s38pgF3OPatHuuRf9-QIULXuV6gLitmsNvXbV6WsZDrKUNl8UOk4RpwPJdshSFgHwFrx-5mU6zwc443vPv0OFidS0gLINGZ_DuBY-1Kcgm4';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->topic,
                "body" => $request->msg,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // dd($response);
        // echo $response;
        print($response);
        curl_close($ch);

        return redirect('send')->with('status', 'Send Successfully');
    }

    public function signin()
    {
        return view('firebase.contact.login');
    }

    public function login(Request $request)
    {
        $user = $request->loginData;
        $contacts = $this->database->getReference($this->tablename)->getValue();
        return view('firebase.contact.index', compact('user', 'contacts'))->with('status', 'Login Successfully');
    }
}
