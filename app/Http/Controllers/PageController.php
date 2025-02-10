<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class PageController extends Controller
{
    public function login_show () {
        return view('index');
    }
    public function reg_show () {
        return view('reg');
    }
    //LOGIN
    public function login (Request $request) {
                    $data = [
                        'login'=>$request->login,
                        'password'=>$request->password,
                    ];
                    $rules = [
                        'login'=>'required',
                        'password'=>'required',
                    ];
                    $messages = [
                        'login.required'=>'Не заполнено поле логина',
                        'password.required'=>'Не заполнено поле пароля',];
                    $validate = Validator::make($data, $rules, $messages);
                    if($validate->fails()){
                        return back()
                        ->withErrors($validate)
                        ->withInput();
                    }
                    else{ 
                        $check = User::where('login','=', $request->login)->exists();
                        if($check == true){
                            $user = User::select('id','login','password','role')->where('login', '=', $request->login)->get();
                            foreach($user as $u){
                                $password = $u->password;
                                $id = $u->id;
                                $role = $u->role;
                            }
                            if (Hash::check($request->password, $password)) {
                                Auth::login( User::find($id));
                                if ($role == 'user') {
                                    return redirect()->route('my_appls')->withErrors(['message'=>'Вы вошли в профиль!']);
                                }
                                else if ($role == 'admin') {
                                    return redirect()->route('all_appls')->withErrors(['message'=>'Вы вошли в профиль как админ!']);
                                }
                            } else {
                                return back()->withErrors(['password'=>'Неверный пароль!'])->withInput();
                        }
                       }
                       else{
                            return back()->withErrors(['login'=>'Нет такого пользователя!'])->withInput();
                       }
                    }
    }
    public function logout () {
        Auth::logout();
        return redirect()->route('login_show')->withErrors(['message'=>'Вы вышли из аккаунта']);
    }
    public function reg (Request $request) {
        $data = $request->all();
        $rules = [
            'login'=>'required|unique:users',
            'password'=>'required|min:6',
            'fio'=>'required|regex:/^[А-Яа-я- ]+$/u',
            'phone'=>'required|regex:/^\+7\d{3}-\d{3}-\d{2}-\d{2}+$/u',
            'email'=>'required|email',
        ];
        $messages = [
            'login.required'=>'Не заполнено поле логина',
            'password.required'=>'Не заполнено поле пароля',
            'fio.required'=>'Не заполнено поле ФИО',
            'phone.required'=>'Не заполнено поле телефона',
            'email.required'=>'Не заполнено поле электронной почты',
            'login.unique'=>'Такой логин занят',
            'password.min'=>'Пароль должен содержать минимум 6 символов',
            'fio.regex'=>'Неверный формат ФИО',
            'phone.regex'=>'Неверный формат телефона',
            'email.email'=>'Неверный формат электронной почты'];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return back()
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $user = User::create(['fio'=>$request->fio,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'login'=>$request->login,
            'password'=>Hash::make($request->password)]);
            Auth::login($user);
            return redirect()->route('my_appls')->withErrors(['message'=>'Вы вошли в профиль!']);
        }
                 
    }
    public function my_appls(){
            $soon = Application::select('*')->where('user_id', Auth::user()->id)->orderBy('date', 'ASC')->get();
            $count = $soon->count();
            return view('my_appls', ['appls'=>$soon, 'count' => $count]);
    }
    public function send_appl(){
        return view('send_appl');
    }
    public function send_appl_db (Request $request) {
        $datetime = $request->date.' '.$request->time;
        $data = $request->all();
        $rules = [
            'phone'=>'regex:/^\+7\d{3}-\d{3}-\d{2}-\d{2}+$/u',
        ];
        $messages = [
            'phone.regex'=>'Неверный формат телефона',];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return back()
            ->withErrors($validate)
            ->withInput();
        }
        else{
            if ($request->type == 'иная услуга') {
                $appl = Application::create(['user_id'=>Auth::user()->id,
                'text'=>$request->text,
                'phone'=>$request->phone,
                'type'=>$request->type,
                'pay'=>$request->pay,
                'date'=>$datetime,
                'address'=>$request->address,]);
            }
            else {
                $appl = Application::create(['user_id'=>Auth::user()->id,
                'phone'=>$request->phone,
                'type'=>$request->type,
                'pay'=>$request->pay,
                'date'=>$datetime,
                'address'=>$request->address,]);
            }
           
            return redirect()->route('my_appls')->withErrors(['message'=>'Вы отправили заявку!']);
        }

    }

    public function all_appls () {
        $soon = Application::selectRaw('applications.*, users.fio')->join('users', 'users.id', '=', 'applications.user_id')->orderBy('date', 'ASC')->get();
            $count = $soon->count();
            return view('admin/all_appls', ['appls'=>$soon, 'count' => $count]);
    }

    public function change_status (Request $request) {
        if ($request->status == 'отменено') {
            Application::where('id', $request->id)->update(['status'=>$request->status, 'admin_text'=>$request->admin_text]);
        }
        else {
            Application::where('id', $request->id)->update(['status'=>$request->status,]);

        }
        return redirect()->route('all_appls')->withErrors(['message'=>'Вы изменили статус!']);
    }

}
