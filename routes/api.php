<?php

use App\Feature;
use App\Group;
use App\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function(){
//    $user = User::where('id', '1')->first();
//    or
//    $user = User::find(1); //和上面的一樣 find() 方法是用來取指定id的資料 這邊就是取 id=1 的資料

//    dd($user->groups);
    // 這裡應該要用first()而不是get(); 因為first()會把那個資料那拿出來，為一個model, 可以再接->groups
    // 而get()會拿一個collection，因此沒有->groups這個方法
    // 這邊關聯到groups必須加s是因為在User.php裡面的function name裡有加s

//    $groups = Group::where('id', '1')->first();
//    $groups = Group::find(2);
//    dd($groups->users);
//    確認可以多對多取到值


//    $User = User::find(1);
//    $User->groups()->attach(1);
//    $User->groups()->attach(2);
//    $User->groups()->attach([1,2]); //上面兩個會等於這個，也就是可以用array的方式一次關聯多個
//    把User裡面id是1的關聯到group2, 也就是pivot裡變成user_id 1對應到group_id: 2

//    $User = User::find(2);
//    $User->groups()->update(['group_id' => 2]);
//    把原本在group1的user1 update 成在group2，意即在pivot裡原來是user_id 1 對 group_id 1變成對group_id 2
//    注意這個是要用array

//    $User = User::find(1);
//    $User->groups()->detach(2);
//    把user id1和 group_id2的關聯刪掉

//    $user = User::create(['user_name'=>'test']); // create裡傳的一定要是array
//    $user->groups()->attach([1,2]); // 接著就可以建立關聯了
//    $user->groups()->detach([1,2,3]); // 也可以移除

//    $user2 = User::first(); // 在users裡選第一筆
//    $user2->groups()->update(['group_id'=>2]); // 把第一筆user對應的group_id給update到2

//    $group = Group::first();
//    $group->features()->attach(1);

//    $feature = Feature::find(1);
//    $feature->users()->attach(2);
//    $binding = Feature::first()->users()->get();
//    dd($binding[0]->id);  確定可以把feature_id是1的資料找到對應的user, 然後把user_id取出來



    return response('success');
});

// 新增 User 並指派 Group

// 新增 User 並指派 Feature

// 既有 User 指派 新Group
Route::post('/assignUserToGroup', function(){
    $input = request()->all();  // 取得input
    $user_name = $input['user_name'];  // 取得 user_name
    $group_name = $input['group_name'];  // 取得 group_name
    $user = User::where('user_name', $user_name)->first(); // 根據user_name取得對應的User model
    $group = Group::where('group_name', $group_name)->first(); // 根據group_name取得對應的Group model
    $user->groups()->attach($group->id); // 指派user到對應的group
    return response('success');
});

// 既有 User 指派 Feature
Route::post('/assignUserToFeature', function(){
    $input = request()->all();  // 取得input
    $user_name = $input['user_name'];  // 取得 user_name
    $feature_name = $input['feature_name'];  // 取得 feature_name
    $user = User::where('user_name', $user_name)->first(); // 根據user_name取得對應的User model
    $feature = Feature::where('feature_name', $feature_name)->first(); // 根據feature_name取得對應的Feature model
    $user->features()->attach($feature->id); // 指派user到對應的feature
    return response('success');
});

// 既有 Group 指派 Feature
Route::post('/assignGroupToFeature', function() {
    $input = request()->all();  // 取得input
    $group_name = $input['group_name'];  // 取得 group_name
    $feature_name = $input['feature_name'];  // 取得 feature_name
    $group = Group::where('group_name', $group_name)->first(); // 根據group_name取得對應的Group model
    $feature = Feature::where('feature_name', $feature_name)->first(); // 根據feature_name取得對應的Feature model
    $group->features()->attach($feature->id); // 指派group到對應的feature
    return response('success');
});

//Route::get('/sign-in', function(){
//    $input = request()->all();  // 取得input
//    $user_name = $input['user_name'];
//    session()->put('user_name', $user_name);
////    dd(session('user_name'));
//    return redirect('/api/featureA');
//});
//Route::get('/featureA', 'authPracticeController@featureA');


Route::post('/featureA', function(Request $request){

    // 根據user_name 取得user_id
    $id_in_users = User::where('user_name', $request->user_name)->first()->id;

    // 取得該feature的id
    $id_in_features = Feature::where('feature_name', $request->feature_name)->first()->id;
    // 取得該user可使用的feature的id
    $features_user_can_proceed = User::find($id_in_users)->features->pluck('id')->toArray();
//    pluck()這個方面可以用來取collection裡所有指定key的value，最後再轉成array供比較
//    $features_user_can_proceed = User::find($id_in_users)->features()->pluck('id')->toArray();
//    這個寫法也可以(features多了括號)，差別是?

    // 取得該user在哪些groups內
    $groups_user_belongs_to = User::find($id_in_users)->groups->pluck('id')->toArray();
//    dd($groups_user_belongs_to);

    // 取得哪些groups有權限使用該feature
    $groups_with_access_to_feature = Feature::find($id_in_features)->groups->pluck('id')->toArray();
//    dd($groups_with_access_to_feature);


//    dd(in_array($groups_user_belongs_to, $groups_with_access_to_feature));
    // 若該feature的id在user可使用的feature清單內，則回覆ok
    if(in_array($id_in_features, $features_user_can_proceed)) {
        return response('OK to go because you can proceed this feature');
    } elseif (array_intersect($groups_user_belongs_to, $groups_with_access_to_feature)) {
        return response('OK to go because your group can proceed this feature ');
    } else {
        return response('Sorry, permission denied');
    }

//    亦可用DB語法直接撈該user可以使用的feature有啥 出來的$result 會是object 所以要再轉成array後做array_intersect
//    $result = DB::select("(select user_name, feature_user.feature_id from users join feature_user on users.id = feature_user.user_id where users.id = 1) UNION
//    (select user_name, feature_group.feature_id from users join group_user on users.id = group_user.user_id  join feature_group on group_user.group_id = feature_group.`group_id` where users.id = 1)");
//    $array = array();
//    foreach ($result as $result) {
//        array_push($array, $result->feature_id);
//    }


    $user_name = $input['user_name'];
    $user = User::where('user_name', $user_name)->first(); // 取得user model
    $user_id = $user->id; // 藉由user_name取得user_id
    $user_group = $user->groups[0]->get('id'); // 取得user所屬group

    $feature = Feature::where('feature_name',$input['feature_name'])->firstorFail(); // 取得輸入的feature
    $user = $feature->users->all(); // 取得可以使用該feature的user
    $group = $feature->groups->all(); // 取得可以使用該feature的group

//    dd($user_group);

//    $result = array_intersect($user_group, $group);
//    dd($result);

////    只判斷user和feature
//    if ($user[0]->id == $user_id) { // 比較可以使用該feature的user_id是和打進來的user_id一致，
//                                       如果user[]裡面不只一筆資料?
//        echo ('success'); // 若一致，success
//    } else {
//        echo ('fail');  // 若不同，fail
//    }

//    user、group都要用來判斷feature
    if ($user[0]->id == $user_id) // 比較可以使用該feature的user_id是和打進來的user_id一致，
    {
        echo ('success'); // 若一致，success
    }       elseif($group == $user_group)
    {
        echo ('success');
    }

});





Route::post('/featureB', function(){
    $input = request()->all();  // 取得input
    $user_name = $input['user_name'];
    $user = User::where('user_name', $user_name)->first(); // 取得user model
    $user_id = $user->id; // 藉由user_name取得user_id
    $user_group = $user->groups[0]->get('id'); // 取得user所屬group
    dd($user_group);

    $feature = Feature::where('feature_name',$input['feature_name'])->firstorFail(); // 取得輸入的feature
    $user = $feature->users->all(); // 取得可以使用該feature的user
    $group = $feature->groups->all(); // 取得可以使用該feature的group

//    dd($user_group);

//    $result = array_intersect($user_group, $group);
//    dd($result);

////    只判斷user和feature
//    if ($user[0]->id == $user_id) { // 比較可以使用該feature的user_id是和打進來的user_id一致，
//                                       如果user[]裡面不只一筆資料?
//        echo ('success'); // 若一致，success
//    } else {
//        echo ('fail');  // 若不同，fail
//    }

//    user、group都要用來判斷feature
    if ($user[0]->id == $user_id) // 比較可以使用該feature的user_id是和打進來的user_id一致，
    {
        echo ('success'); // 若一致，success
    }       elseif($group == $user_group)
            {
                echo ('success');
            }

});


