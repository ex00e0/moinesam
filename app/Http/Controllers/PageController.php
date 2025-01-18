<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class PageController extends Controller
{
    public function login_show () {
        return view('login');
    }
    //LOGIN
    public function login (Request $request) {
       $check = User::where('login','=', $request->login)->exists();
       if(strlen(strip_tags(trim($request->password))) != 0 && strlen(strip_tags(trim($request->login))) != 0){
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
                        return redirect()->route('limit_3')->withErrors(['message'=>'Вы вошли в профиль!']);
                    }
                    else if ($role == 'admin') {
                        return redirect()->route('admin/index')->withErrors(['message'=>'Вы вошли в профиль как админ!']);
                    }
                } else {
                    return back()->withErrors(['message'=>'Неверный пароль!'])->withInput();
            }
           }
           else{
                return back()->withErrors(['message'=>'Нет такого пользователя!'])->withInput();
           }
       }
       else{
            return back()->withErrors(['message'=>'Заполните все поля'])->withInput();
       }
       
    }
    public function logout () {
        Auth::logout();
        return redirect()->route('limit_3')->withErrors(['message'=>'Вы вышли из аккаунта']);
    }
// ALL EVENTS ON GENERAL PAGE
    public function get_all_events($id=null){
        $one_event = null;
        if($id){
            $one_event = Event::select('*')->where('id', '=', $id)->get()[0];
        }
        $events = Event::select('*')->get();
        $count = Event::select('*')->get()->count();
        return view('all_events', ['events'=>$events, 'count'=>$count, 'one_event'=>$one_event, 'event_id'=>$id]);
    }

    public function all_news($id=null){
        $one_event = null;
        if($id){
            $one_event = News::select('*')->where('id', '=', $id)->get()[0];
        }
        $events = News::select('*')->get();
        $count = News::select('*')->get()->count();
        return view('all_news', ['news'=>$events, 'count'=>$count, 'one_new'=>$one_event, 'new_id'=>$id]);
    }
// LIMIT 3 EVENTS (INDEX)
    public function limit_3(){
        $soon = Event::select('*')->limit(3)->orderBy('date', 'ASC')->get();
        $news = News::select('*')->limit(4)->orderBy('created_at')->get();
        return view('index', ['events'=>$soon, 'news' => $news]);
    }
    public function admin_index($id=null){
        $one_event = null;
        if($id){
            $one_event = Event::select('*')->where('id', '=', $id)->get()[0];
        }
        $events = Event::select('*')->get();
        $count = Event::select('*')->get()->count();
        return view('admin/index', ['events'=>$events, 'count'=>$count, 'one_event'=>$one_event, 'event_id'=>$id]);
    }
// LIMIT 4 NEWS (INDEX)
    public function limit_4($news_id = null){
        $one_news = null;
        if($news_id){
            $one_news = News::select('*')->where('id', '=', $news_id)->get()[0];
        }
        // ADD LIMIT 4
        $news = News::select('*')->orderBy('created_at')->get();

        $count = $news->count();
        return view('news', ['news'=>$news, 'count'=>$count, 'one_news'=>$one_news, 'news_id'=>$news_id]);
    }
// ADMIN CREATE EVENT
    public function create_event(Request $request){
        $data = [
            'title'=>$request->title,
            'subtitle'=>$request->subtitle,
            'age'=>$request->age,
            'long'=>$request->long,
            'date'=>$request->date,
            'description'=>$request->description,
            'squad'=>$request->squad,
            'image'=>$request->image
        ];
        $rules = [
            'title'=>'required|unique:events',
            'subtitle'=>'required',
            'age'=>'required',
            'long'=>'required',
            'date'=>'required',
            'description'=>'required',
            'squad'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg'
        ];
        $messages = [
            'title.required'=>'Заполните заголовок',
            'title.unique'=>'Заголовок должен быть уникальным',
            'subtitle.required'=>'Заполните подзаголовок',
            'age.required'=>'Выберите возраст',
            'long.required'=>'Выберите продолжительность мероприятия в минутах',
            'date.required'=>'Выберите дату мероприятия',
            'description.required'=>'Заполните описание',
            'squad.required'=>'Заполните команду',
            'image.required'=>'Выберите изображение',
            'image.mimes'=>'Тип файла должен быть изображением'];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('admin/index')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $create = Event::insert([
                'title'=>$request->title,
                'subtitle'=>$request->subtitle,
                'age'=>$request->age,
                'long'=>$request->long,
                'date'=>$request->date,
                'description'=>$request->description,
                'squad'=>$request->squad,
                'image'=>$request->file('image')->getClientOriginalName()
            ]);
            $events = Event::select('*')->get();
            $count = Event::select('*')->get()->count();
            if($create){
                $image_i = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path() . "/images/", $image_i);
                return redirect()->route('admin_index',  ['events'=>$events, 'count'=>$count])->withErrors(['message'=>'Успешное добавление мероприятия!']);
            }
            else{
                return  redirect()->route('admin_index', ['events'=>$events, 'count'=>$count])->withErrors(['message'=>'Не удалось добавить мероприятие!']);
            }
        }
    }
// ADMIN CREATE NEWS
    public function create_news(Request $request){
        $data = [
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$request->image
        ];
        $rules = [
            'title'=>'required|unique:news',
            'description'=>'required',
            'image'=>'required|mimes:jpeg,jpg,png'
        ];
        $messages = [
            'title.required'=>'Заполните заголовок',
            'title.unique'=>'Заголовок должен быть уникальным',
            'description.required'=>'Заполните описание',
            'image.required'=>'Выберите изображение', 
            'image.mimes'=>'Формат файла должен быть jpeg, jpg или png'];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('news')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            // dd($request->image);
            $create_news = News::insert([
                'title'=>$request->title,
                'description'=>$request->description, 
                'image'=>$request->file('image')->getClientOriginalName()
            ]); 
            
            $news = News::select('*')->get();
            $count = News::select('*')->get()->count();
            if($create_news){
                $image_i = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path() . "/img/", $image_i);
                return view('news', ['count'=>$count, 'news'=>$news])->withErrors(['message'=>'Успешное создание новости']);
            }
            else{
                return view('news', ['count'=>$count, 'news'=>$news])->withErrors(['message'=>'Не удалось создать новость'])->withInputs();
            }
            // return view('news', ['image'=>$request->image]);
        }
    }


// ADMIN UPDATE EVENT
    public function update_event(Request $request){
        // dd($request->image);
        $data = [
            'title'=>$request->title,
            'subtitle'=>$request->subtitle,
            'age'=>$request->age,
            'long'=>$request->long,
            'date'=>$request->date,
            'description'=>$request->description,
            'squad'=>$request->squad
        ];
        $rules = [
            'title'=>'required',
            'subtitle'=>'required',
            'age'=>'required',
            'long'=>'required',
            'date'=>'required',
            'description'=>'required',
            'squad'=>'required'
        ];
        $messages = [
            'title.required'=>'Заполните заголовок',
            'subtitle.required'=>'Заполните подзаголовок',
            'age.required'=>'Выберите возраст',
            'long.required'=>'Выберите продолжительность мероприятия в минутах',
            'date.required'=>'Выберите дату мероприятия',
            'description.required'=>'Заполните описание',
            'squad.required'=>'Заполните команду'
        ];
        if($request->image){
            // array_push($data, );
            $data['image'] = $request->image;
            $rules['image'] = 'mimes:jpg,jpeg,png';
            $messages['image.mimes'] = 'Выбранный файл не изображение!';
        }
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('admin/index/'.$request->id)
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $update = Event::where('id', '=', $request->id)->update([
                'title'=>$request->title,
                'subtitle'=>$request->subtitle,
                'age'=>$request->age,
                'long'=>$request->long,
                'date'=>$request->date,
                'description'=>$request->description,
                'squad'=>$request->squad
            ]);
            if($request->image){
                $update = Event::where('id','=', $request->id)->update([
                    'image'=>$request->file('image')->getClientOriginalName()
                ]);
            }
            $events = Event::select('*')->get();
            $count = Event::select('*')->get()->count();
            if($update){
                if($request->image){
                    $image_i = $request->file('image')->getClientOriginalName();
                    $request->file('image')->move(public_path() . "/img/", $image_i);
                }
                return redirect()->route('admin_index', ['count'=>$count, 'events'=>$events])->withErrors(['message'=>'Успешное обновление мероприятия']);
            }
            else{
                return redirect()->route('admin_index', ['events'=>$events, 'count'=>$count])->withErrors(['message'=>'Не удалось добавить мероприятие!']);
            }
        }
    }

// ADMIN UPDATE NEWS
    public function update_news(Request $request){
        $data = [
            'title'=>$request->title,
            'description'=>$request->description
        ];
        $rules = [
            'title'=>'required',
            'description'=>'required'
        ];
        $messages = [
            'title.required'=>'Заполните заголовок',
            'description.required'=>'Заполните описание'
        ];
        if($request->image){
            // array_push($data, );
            $data['image'] = $request->image;
            $rules['image'] = 'mimes:jpg, jpeg, png';
            $messages['image.required'] = 'Выбранный файл не изображение!';
        }
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('news')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            // dd($request->image);
            $update_news = News::where('id', '=', $request->id)->update([
                'title'=>$request->title,
                'description'=>$request->description,
            ]); 
            if($request->image){
                $update_news = News::where('id','=', $request->id)->update([
                    'image'=>$request->file('image')->getClientOriginalName()
                ]);
            }
            
            $news = News::select('*')->get();
            $count = News::select('*')->get()->count();
            if($update_news){
                if($request->image){
                    $image_i = $request->file('image')->getClientOriginalName();
                    $request->file('image')->move(public_path() . "/img/", $image_i);
                }
                return view('news', ['count'=>$count, 'news'=>$news])->withErrors(['message'=>'Успешное обновление новости']);
            }
            else{
                return view('news', ['count'=>$count, 'news'=>$news])->withErrors(['message'=>'Не удалось обновить новость'])->withInputs();
            }
        }
            // return view('news', ['image'=>$request->image]);
    }
// DELETE EVENT ADMIN
    public function delete_event($id){
        $delete = Event::where('id', '=', $id)->delete();
        $events = Event::select('*')->get();
        $count = Event::select('*')->get()->count();
        if($delete){
            return redirect()->route('admin_index',  ['count'=>$count, 'events'=>$events])->withErrors(['message'=>'Успешное удаление мероприятия']);
        }
        else{
            return redirect()->route('admin_index', ['count'=>$count, 'events'=>$events])->withErrors(['message'=>'Не удалось удалить мероприятие']);
        }
    }
// DELETE NEWS ADMIN
    public function news_d($id){
        $delete = News::where('id', '=', $id)->delete();
        $events = News::select('*')->get();
        $count = News::select('*')->get()->count();
        if($delete){
            return view('news', ['count'=>$count, 'events'=>$events])->withErrors(['message'=>'Успешное удаление новости']);
        }
        else{
            return view('news', ['count'=>$count, 'events'=>$events])->withErrors(['message'=>'Не удалось удалить новость']);
        }
    }


    // MORE_INFO
    public function news_more($id){
        $one_news = News::select('*')->where('id', '=', $id)->get();
        return view('one_news', ['info'=>$one_news]);
    }

    public function event_more($id){
        $one_event = Event::select('*')->where('id', '=', $id)->get();
        return view('one_events', ['info'=>$one_event[0]]);
    }
}
