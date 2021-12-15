<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Hash;

class ContactController extends Controller
{

    public function __construct(Database $database, Messaging $messaging)
    {
        $this->database = $database;
        $this->tablename = 'contacts';
        $this->messaging = $messaging;
    }

    public function deviceList()
    {
        $contacts = $this->database->getReference($this->tablename)->getValue();
        return view('firebase.contact.list', compact('contacts'));
    }

    public function create()
    {
        return view('firebase.contact.create');
    }

    public function registerPage()
    {
        return view('firebase.contact.register');
    }

    public function registerDevice(Request $request)
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
        //從RealtimeDB取出所有DeviceToken
        $query = $this->database->getReference($this->tablename)->getValue();
        $firebaseToken = [];
        foreach ($query as $key => $value) {
            foreach ($value as $key => $value) {
                echo array_push($firebaseToken, $value);
                break;
            }
        }
        //參數設定
        $SERVER_API_KEY = 'AAAAuR5Zp74:APA91bEX5iYcNRUUEDC74xxGvMGBjAgD3s38pgF3OPatHuuRf9-QIULXuV6gLitmsNvXbV6WsZDrKUNl8UOk4RpwPJdshSFgHwFrx-5mU6zwc443vPv0OFidS0gLINGZ_DuBY-1Kcgm4';
        //傳送訊息設定
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->topic,
                "body" => $request->msg,
            ]
        ];
        $dataString = json_encode($data);
        //傳送表頭
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        //curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        print($response);
        curl_close($ch);

        return redirect('send')->with('status', 'Send Successfully');
    }
}
