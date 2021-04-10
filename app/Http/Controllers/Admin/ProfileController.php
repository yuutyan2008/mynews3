<?php

namespace App\Http\Controllers\Admin;

//LarabelのRequestクラスを使用する
use Illuminate\Http\Request;
//Controllerクラスを親クラスから継承する
use App\Http\Controllers\Controller;
//App直下のProfileモデルを使う
use App\Profile;
//ProfileHistory Modelを使う
use App\ProfileHistory;
//時刻を扱うために Carbonという日付操作ライブラリを使う
use Carbon\Carbon;


//Controllerを継承してProfileControllerクラスを定義します
class ProfileController extends Controller
{
    // add, create, edit, updateを追加  
    public function add()
    {
        return view('admin.profile.create');
    }


    public function edit(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::find($request->id);
        if (empty($profile)) {
          abort(404);    
      }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      
      unset($profile_form['_token']);      
      
     

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save(); 
      
      //ProfileHistory Modelにも編集履歴を追加
      $profilehistory = new ProfileHistory;
      $profilehistory->profile_id = $profile->id;
      $profilehistory->edited_at = Carbon::now();
      $profilehistory->save();
        
      return redirect(sprintf("admin/profile/edit?id=%d", $profile->id));
    }
      
     // 以下を追記
    public function create(Request $request)
    { 
      // Varidationを行う
      $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();

 
      unset($form['_token']);
      
      // データベースに保存する
      $profile->fill($form);
      $profile->save();

        
        
     // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }  
              
}



