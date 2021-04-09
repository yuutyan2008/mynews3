<?php

namespace App\Http\Controllers\Admin;

//LarabelのRequestクラスを使用する
use Illuminate\Http\Request;
//Controllerクラスを親クラスから継承する
use App\Http\Controllers\Controller;
//App直下のProfileモデルを使う
use App\Profile;

//Controllerを継承してProfileControllerを定義します
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

    public function update()
    {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      
      //画像変更時のエラー防止。userが削除すれば画像なし
      if ($request->remove == 'true') {
          $profile_form['image_path'] = null;
          
      //userがファイルを選択すれば、保存。$profile_formに画像のパスを保存する
      } elseif ($request->file('image')) {
          $path = $request->file('image')->store('public/image');
          $profile_form['image_path'] = basename($path);
          
       //profile Modelに格納されている更新前の画像を、更新のためuserから送られてきたデータとみなす（更新しない）   
      } else {
          $profile_form['image_path'] = $profile->image_path;
      }

      unset($profile_form['image']);
      unset($profile_form['remove']);
      unset($profile_form['_token']);      
      
     

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();       
        
        return redirect('admin/profile/edit');
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



