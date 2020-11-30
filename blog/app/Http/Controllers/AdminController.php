<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\League;
use App\Teams;
use App\AddNews;
use Illuminate\Support\Facades\input;
use File;
use App\AprovedNews;
use App\Comments;
use Auth;
use App\CommentsReply;
use App\Likes;
use Validator;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    public function AdminHomePAge(){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $news = AddNews::orderBy("created_at", "desc")->paginate(7);
        return view("admin.AdminHomePage", ["news" => $news, "leagues" => $leagues, 
        "amount"=>$aproved_news_ammount, "title" => "მთავარი გვერდი"]);
    }
    public function AddLeague(){
      $leagues = League::get();
      $aproved_news_ammount = AprovedNews::get()->count();
      return view("admin.AddLeague", ["leagues"=>$leagues, "amount"=>$aproved_news_ammount,
      "title" => "ჩემპიონატები"]);  
    }
    public function AddLeagueDatabase(Request $request)
    {
        League::create([
            "leagues"=>$request->input("league")
        ]);
        return redirect()->back()->with('success', 'ჩემპიონატი წარმატებით დაემატა');
    }
    public function ShowTeams($id){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $teams = Teams::where("LeagueId", $id)->get();
        return view("admin.ShowTeams", ["teams"=>$teams, "leagues" => $leagues, "amount"=>$aproved_news_ammount,
        "title"=>"გუნდები"]);
    }
    public function AddTeams(Request $request){
        Teams::create([
            "LeagueId"=>$request->input("league_id"),
            "team"=>$request->input("team")
        ]);
        return redirect()->back()->with('success', "გუნდი წარმატებით დაემატა");
    }
    public function DeleteTeams(Request $request){
        Teams::where("id", $request->input("id"))->delete();
        return redirect()->back();
    }
    public function AddNewsBlade(Request $request){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $team = Teams::where("id", $request->input("id"))->firstOrFail();
        return view("admin.AddNewsBlade", ["team"=>$team, "leagues" => $leagues, "amount"=>$aproved_news_ammount,
        "title" => "სიახლის დამატება"]);
    }
    public function AddNewsToDatabase(Request $request){
        $validateError = Validator::make($request->all(), [
            "title"=>"required",
            "short-description"=>"required",
            "description"=>"required",
            "image"=>"required"
        ]);
        if ($validateError->fails()){
            return redirect()->route("AdminHome")->with("danger", "შეავსეთ ყველა სავალდებულო ველი");
        }
        if (Input::file("image")){
            $dp = public_path("images");
            $filename = uniqid().".jpg";
            $img = Input::file("image")->move($dp, $filename);
        }
       AddNews::create([
           "team_id"=>$request->input("id"),
           "league_id"=>$request->input("league_id"),
           "title"=>$request->input("title"),
           "short_description"=>$request->input("short-description"),
           "description"=>$request->input("description"),
           "image"=>$filename,
           "user_id"=>Auth::user()->id,
           "username"=>Auth::user()->name
       ]);
       return redirect()->route("AdminHome")->with('success', 'სიახლე წარმატებით დაემატა');
    }
    public function AdminShowAprovedNews(){
        $aproved_news_ammount = AprovedNews::get()->count();
        $leagues = League::get();
        $aproved_news = AprovedNews::orderBy("created_at", "desc")->get();
        if ($aproved_news_ammount > 0){
            return view("admin.AprovedNewsBlade", ["aproved_news"=>$aproved_news, "leagues" => $leagues, 
            "amount"=>$aproved_news_ammount, "title"=>"დასადასტურებელი სიახლეები"]);
        }
        else{
            return redirect()->route("AdminHome")->with("danger", "სიახლეები არ მოიძებნა");
        }
    }
    public function AdminShowNews($id){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $news = AprovedNews::where("id", $id)->firstOrFail();
        return view("admin.AdminShowNews", ["new"=>$news, "leagues" => $leagues, "amount"=>$aproved_news_ammount,
        "title" => $news->title]);
    }
    public function AdminDeleteUserPost(Request $request){
        AprovedNews::where("id", $request->input("id"))->delete();
        $count_approved_news = AprovedNews::where("id", $request->input("id"))->count();
        if ($count_approved_news > 0){
            return redirect()->route("AdminShow")->with('info', 'სიახლე წარმატებით წაიშალა');
        }
        else{
            return redirect()->route("AdminHome")->with('info', 'სიახლე წარმატებით წაიშალა');
        }
    }
    public function AprovedPost(Request $request){
        if (input::file("image")){
            $dp = public_path("images");
            $filename = uniqid().".jpg";
            $img = input::file("image")->move($dp, $filename);
        }
        else{
            $filename = $request->input("image_name");
        }
        AddNews::create([
            "team_id"=>$request->input("team_id"),
            "league_id"=>$request->input("league_id"),
            "title"=>$request->input("title"),
            "short_description"=>$request->input("short_description"),
            "description"=>$request->input("description"),
            "image"=>$filename,
            "user_id"=>$request->input("user_id"),
            "username"=>$request->input("username")
        ]);
        AprovedNews::where("id", $request->input("id"))->delete();
        return redirect()->route("AdminHome")->with('success', 'სიახლე წარმატებით შეინახა');
    }
    public function UpdateBlade($id){
        $aproved_news_ammount = AprovedNews::get()->count();
        $leagues = League::get();
        $news = AprovedNews::where("id", $id)->firstOrFail();
        return view("admin.UpdateBlade", ["news"=>$news, "leagues" => $leagues, "amount"=>$aproved_news_ammount,
        "title" => "განახლება"]);
    }
    public function AdminShow($id){
        $aproved_news_ammount = AprovedNews::get()->count();
        $leagues = League::get();
        $replyComments = CommentsReply::where("post_id", $id) -> get();
        $leagues = League::get();
        $news = AddNews::where("id", $id) -> firstOrFail();
        $comments = Comments::where("post_id", $id) -> get();
        $count_comments = Comments::where("post_id", $id)->count();
        if ($count_comments > 0){
            return view("admin.AdminShow", ["news" => $news, "comments" => $comments, "leagues" => $leagues, 
            "replyComments"=>$replyComments, "amount"=>$aproved_news_ammount, "title" => $news->title]);
        }
        else{
            return view("admin.AdminShowWithoutError", ["news"=> $news, "leagues"=>$leagues,
             "amount"=>$aproved_news_ammount, "title" => $news->title]);
        }
    }
    public function AdminDeleteComments($id){
        Comments::where("id", $id)->delete();
        return redirect()->back();
    }
    public function logout(){
        Auth::logout();
        return redirect()->route("GuestHome");
    }
    public function Comment(Request $request){
        Comments::create([
            "post_id"=>$request->input("post_id"),
            "comment"=>$request->input("comment"),
            "post_own_id"=>$request->input("post_owner_id"),
            "user_id"=>$request->input("user_id"),
            "username"=>Auth::user()->name
        ]);
        return redirect()->back();
    }
    public function AdminAccount(){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $news = AddNews::orderBy("created_at", "desc")->where("user_id", Auth::user()->id)->paginate(3, ['*'], 'news');
        $comments = Comments::orderBy("created_at", "desc")->where("user_id", Auth::user()->id)-> paginate(3, ['*'], 'comments');
        $post_ammount = AddNews::where("user_id", Auth::user()->id)->count();
        $comments_ammount = Comments::where("user_id", Auth::user()->id)->count();
        return view("admin.AdminProfile", ["news"=>$news, "comments"=>$comments, "leagues" => $leagues,
        "PostAmount" => $post_ammount, "CommentAmount"=>$comments_ammount, "amount" => $aproved_news_ammount,
        "title" => Auth::user()->name]);
    }
    public function ShowWithLeague($id){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $teams = Teams::where("LeagueId", $id) -> get();
        $news = AddNews::orderBy("created_at", "desc")->where("league_id", $id) -> paginate(7);
        $league_name = League::select("leagues")->where("id", $id)->firstOrFail();
        return view("admin.ShowWithLeague", ["teams" => $teams, "news" => $news, "leagues" => $leagues, 
        "amount"=>$aproved_news_ammount, "title"=>$league_name->leagues]);  
    }
    public function ShowWithTeams($id){
        $leagues = League::get();
        $aproved_news_ammount = AprovedNews::get()->count();
        $news = AddNews::orderBy("created_at", "desc")->where("team_id", $id) -> paginate(7);
        $team_name = Teams::select("team")->where("id", $id)->firstOrFail();
        return view("admin.ShowWithTeam", ["leagues" => $leagues, "news" => $news, 
        "amount"=>$aproved_news_ammount, "title" => $team_name->team]);
    }
    public function SaveReplyComment(Request $request){
        CommentsReply::create([
            "post_id"=> $request->input("post_id"),
            "comment"=> $request->input("reply_comment"),
            "post_own_id"=> $request->input("post_owner_id"),
            "user_id"=> Auth::user()->id,
            "username"=> Auth::user()->name,
            "comment_id"=> $request->input("comment_id"),
            "mather_comment_id"=> $request->input("mather_comment_id")
        ]);
        return redirect()->back();
    }
    public function AdminSeeUser($id){
        $aproved_news_ammount = AprovedNews::get()->count();
        $news = AddNews::where("user_id", $id) -> paginate(3, ['*'], 'news');
        $comments = Comments::where("user_id", $id) -> paginate(3, ['*'], 'comments');
        $post_ammount = AddNews::where("user_id", $id) -> count();
        $comments_ammount = Comments::where("user_id", $id) -> count();
        $username = AddNews::select("username")->where("user_id", $id) -> firstOrFail();
        $leagues = League::get();
        return view("admin.AdminSeeUser", ["comments" => $comments , "news" => $news, 
        "leagues" => $leagues, "PostAmount" => $post_ammount, "CommentAmount" => $comments_ammount,
        "username"=>$username, "amount"=>$aproved_news_ammount, "title" => $username->username]);
    }
    public function AdminDeletePost(Request $request){
        AddNews::where("id", $request -> input("news_id"))->delete();
        return redirect()->back()->with("success", "პოსტი წაიშალა");
    }
    public function AdminUpdateComment(Request $request){
        Comments::where("id", $request -> input("id"))->update([
            "comment" => $request->input("comment")
        ]);
        return redirect()->back();
    }
    public function AdminDeleteReplyComment($id){
        CommentsReply::where("id", $id)->delete();
        return redirect()->back();
    }
    public function AdminUpdateReplyComment(Request $request){
        CommentsReply::where("id", $request->input("id"))->update([
            "comment" => $request->input("reply_comment")
        ]);
        return redirect()->back();
    }
    public function AdminLikePost(Request $request){
        $current_likes = Likes::where("post_id", $request->input("id"))->count() + 1;
        Likes::create([
            "user_id" => Auth::user()->id,
            "post_id" => $request->input("id"),
            "likes" => $current_likes
        ]);
        return redirect()->back();
    }
}