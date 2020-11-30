<?php

Route::get('/', "Guest@index") -> name("GuestHome");
Route::get('/Guest/show/post{id}', "Guest@show") -> name("GuestShowPost");
Route::get("/guest/show/user/{id}", "Guest@ShowUSer") -> name("GuestShowUser");
Route::get("/show/with/league/{id}", "Guest@ShowWithLeague") -> name("ShowWithLeague");
Route::get("/show/with/team/{id}", "Guest@ShowWithTeams") -> name("ShowWithTeams");

//ადმინის როუტები
Route::group(['middleware' => ['auth', 'admin']], function(){
    Route::get("/admin", "AdminController@AdminHomePAge")->name("AdminHome");
    Route::get("/admin/add/league", "AdminController@AddLeague")->name("AddLeague");
    Route::post("/admin/save/database", "AdminController@AddLeagueDatabase")->name("SaveLeague");
    Route::get("/admin/show/teams/{id}", "AdminController@ShowTeams")->name("AdminShowTeams");
    Route::post("/admin/add/team", "AdminController@AddTeams")->name("AdminAddTeams");
    Route::post("/admin/delete/team", "AdminController@DeleteTeams")->name("AdminDeleteTeam");
    Route::any("/admin/add/news", "AdminController@AddNewsBlade")->name("AdminAddNews");
    Route::post("/admin/add/news/database", "AdminController@AddNewsToDatabase")->name("AdminSaveNews");
    Route::get("/admin/show/approved/new", "AdminController@AdminShowAprovedNews")->name("AdminShow");
    Route::get("/admin/show/new/{id}", "AdminController@AdminShowNews")->name("AdminAprovedShowNews");
    Route::post("/admin/delete/user/post", "AdminController@AdminDeleteUserPost")->name("AdminDeleteApprovedPost");
    Route::post("/admin/aproved/news", "AdminController@AprovedPost")->name("AdminAproved");
    Route::get("/admin/show/update/post/{id}", "AdminController@UpdateBlade")->name("UpdateBlade");
    Route::get("/admin/show/{id}", "AdminController@AdminShow")->name("AdminShowNews");
    Route::get("/admin/delete/comments/{id}", "AdminController@AdminDeleteComments") -> name("AdminDeleteComment");
    Route::get('logout', 'AdminController@logout') -> name("logout");
    Route::post('/admin/add/comment', "AdminController@Comment") -> name("AdminAddComment");
    Route::post('/admin/delete/post, "AdminController@AdminDeletePost') -> name("AdminDeletePost");
    Route::get("/admin/profiel/page", "AdminController@AdminAccount") -> name("AdminProfile");
    Route::get("/admin/show/news/with/league/{id}", "AdminController@ShowWithLeague") -> name("AdminShowNewsWithLeague");
    Route::get("/admin/show/news/with/team/{id}", "AdminController@ShowWithTeams") -> name("AdminShowNewsWithTeam");
    Route::post("/admin/reply/comment", "AdminController@SaveReplyComment") -> name("AdminReplyComment");
    Route::get("/admin/see/user/{id}", "AdminController@AdminSeeUser") -> name("AdminSeeUser");
    Route::post("/admin/delete/aproved/post", "AdminController@AdminDeletePost") -> name("AdminDeleteAprovedPost");
    Route::post("/admin/upadte/comment", "AdminController@AdminUpdateComment") -> name("AdminUpdateOwnComment");
    Route::get("/admin/delete/reply/comment/{id}", "AdminController@AdminDeleteReplyComment") -> name("AdminDeleteReplyComment");
    Route::post("/admin/update/reply/comment", "AdminController@AdminUpdateReplyComment") -> name("AdminUpdateReplyComment");
    Route::post("/admin/likes/post", "AdminController@AdminLikePost") -> name("AdminLikePost");
});

//მომხმარებლის როუტები
Route::get("/user", "UserController@UserHome")->name("UserHome");
Route::get("/choice/league", "UserController@UserChoiceLeague")->name("ChoiceLeague");
Route::get("/user/choice/team{id}", "UserController@ChoiceTeam")->name("UserChoiceTeam");
Route::post("/user/add/news", "UserController@AddNews")->name("UserAddNews");
Route::post("/save/post/admin/database", "UserController@SaveToAdminDatabase")->name("SavaAdminDatabase");
Route::get("/show/news/{id}", "UserController@Show")->name("ShowPost");
Route::post("/user/comment", "UserController@comments")->name("comments");
Route::post("/user/delete/own/post", "UserController@UserDeletePost")->name("UserDeletePost");
Route::get("/user/delete/comment/{id}", "UserController@DeleteCommet")->name("UserDeleteComments");
Route::get("/user/show/profile", "UserController@UserProfile") -> name("UserProfile");
Route::get("/user/show/with/league/{id}", "UserController@ShowWithLeague") -> name("UserShowWithLeague");
Route::get("/user/show/with/team/{id}", "UserController@ShowWithTeams") -> name("UserShowWithTeam");
Route::post("/user/reply/comments", "UserController@SaveReplyComments") -> name("UserReplyComments");
Route::get("/user/see/user/{id}", "UserController@UserSeeUserProfile") -> name("UserSeeUser");
Route::get("/user/delete/reply/comment/{id}", "USerController@UserDeleteReplyComment") ->name("UserDeleteReplyComments");
Route::post("/user/update/comment", "UserController@UpdateComment") -> name("UserUpdateComments");
Route::post("/user/update/reply/comment", "UserController@UserUpdateReplyComments") -> name("UserUpdateReplyComments");

Auth::routes(["verify"=>true]);

Route::get("/user", "UserController@UserHome")->name("UserHome");

Auth::routes();

Route::get("/user", "UserController@UserHome")->name("UserHome");
