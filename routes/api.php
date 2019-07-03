<?php

use App\authPractice\Entity\Feature;
use App\authPractice\Entity\Group;
use App\authPractice\Entity\User;
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

    $feature = Feature::find(1);
    $feature->users()->attach(2);
    return response('success');
});
