<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\League;
use App\Teams;
use App\AprovedNews;
use Illuminate\Support\Facades\input;
use File;
use App\AddNews;
use App\Comments;
use Auth;
use App\CommentsReply;
use App\Likes;
use Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    public function UserHome(){
        $leagues = League::get();
        $news = AddNews::orderBy("created_at", "desc")->paginate(7);
        return view("user.home", ["news"=>$news, "leagues" => $leagues, "title"=>"მთავარი გვერდი"]);
    }
    public function UserChoiceLeague(){
        $leagues = League::get();
        return view("user.ChoiceLeague", ["leagues"=>$leagues, "title" => "აირჩიეთ ჩემპიონატი"]);
    }
    public function ChoiceTeam($id){
        $leagues = League::get();
        $teams = Teams::where("LeagueId", $id)->get();
        return view("user.ChoiceTeams", ["teams"=>$teams, "leagues" => $leagues, "title" => "აირჩიეთ გუნდი"]);
    }
    public function AddNews(Request $request){
        $leagues = League::get();
        $team = Teams::where("id", $request->input("id"))->firstOrFail();
        return view("user.UserAddNews", ["team"=>$team, "leagues" => $leagues, "title" => "სიახლის დამატება"]);
    }
    public function SaveToAdminDatabase(Request $request){
        $validatorError = Validator::make($request->all(),[
            "title"=>"required",
            "short-description"=>"required",
            "description"=>"required",
            "image"=>"required"
        ]);
        if($validatorError->fails()){
            return redirect()->route("UserHome")->with("danger", "შეავსეთ ყველა სავალდებულო ველი");
        }
        else if (Input::file("image")){
            $dp = public_path("images");
            $filename = uniqid().".jpg";
            $img = Input::file("image")->move($dp, $filename);
        }
        AprovedNews::create([
           "team_id"=>$request->input("id"),
           "league_id"=>$request->input("league_id"),
           "title"=>$request->input("title"),
           "short_description"=>$request->input("short-description"),
           "description"=>$request->input("description"),
           "image"=>$filename,
           "user_id"=>Auth::user()->id,
           "username"=>Auth::user()->name
       ]);
       return redirect()->route("UserHome")->with('info', 'სიახლე გაეგზავნა ადმინს დაელოდეთ დადასტურებას');
    }
    public function Show($id){
        $replyComments = CommentsReply::where("post_id", $id)->get();
        $leagues = League::get();
        $news = AddNews::where("id", $id)->firstOrFail();
        $comments = Comments::where("post_id", $id)->get();
        $count_comments = Comments::where("post_id", $id)->count();
        if($count_comments > 0){
            return view("user.show", ["news"=>$news, "comments"=>$comments, "leagues" => $leagues, "replyComments"=>$replyComments,
            "title" => $news->title]);
        }
        else{
            return view("user.ShowWithOutComments", ["news"=>$news, "leagues"=>$leagues, "title"=>$news->title]);
        }
    }
    public function comments(Request $request){
        Comments::create([
            "post_id"=>$request->input("post_id"),
            "comment"=>$request->input("comment"),
            "post_own_id"=>$request->input("post_owner_id"),
            "user_id"=>Auth::user()->id,
            "username"=>Auth::user()->name
        ]);
        return redirect()->back();
    }
    public function UserDeletePost(Request $request){
        AddNews::where("id", $request->input("news_id"))->delete();
        return redirect()->back()->with('success', 'პოსტი წარმატებით წაიშალა');
    }
    public function DeleteCommet($id){
        Comments::where("id", $id)->delete();
        return redirect()->back();
    }
    public function UserProfile(){
        $leagues = League::get();
        $news = AddNews::orderBy("created_at", "desc")->where("user_id", Auth::user()->id)->paginate(3, ['*'], 'news');
        $comments = Comments::orderBy("created_at", "desc")->where("user_id", Auth::user()->id)-> paginate(3, ['*'], 'comments');
        $post_ammount = AddNews::where("user_id", Auth::user()->id)->count();
        $comments_ammount = Comments::where("user_id", Auth::user()->id)->count();
        return view("user.account", ["news"=>$news, "comments"=>$comments, "leagues" => $leagues,
        "PostAmount" => $post_ammount, "CommentAmount"=>$comments_ammount, "title" => Auth::user()->name]);
    }
    public function ShowWithLeague($id){
        $leagues = League::get();
        $news = AddNews::orderBy("created_at", "desc")->where("league_id", $id) -> paginate(7);
        $teams = Teams::where("LeagueId", $id) -> get();
        $league_name = League::select("leagues")->where("id", $id)->firstOrFail();
        return view("user.ShowWithLeague", ["leagues" => $leagues, "news" => $news, "teams" => $teams,
        "title" => $league_name->leagues]);
    }
    public function ShowWithTeams($id){
        $leagues = League::get();
        $news = AddNews::orderBy("created_at","desc")->where("team_id", $id) -> paginate(7);
        $team_name = Teams::select("team")->where("id", $id)->firstOrFail();
        return view("user.ShowWithTeam", ["leagues" => $leagues, "news" => $news, "title"=>$team_name->team]);
    }
    public function SaveReplyComments(Request $request){
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
    public function UserSeeUserProfile($id){
        $news = AddNews::orderBy("created_at", "desc")->where("user_id", $id) -> paginate(3, ['*'], "news");
        $comments = Comments::orderBy("created_at", "desc")->where("user_id", $id) -> paginate(3, ['*'], "comments");
        $post_ammount = AddNews::where("user_id", $id) -> count();
        $comments_ammount = Comments::where("user_id", $id) -> count();
        $username = AddNews::select("username")->where("user_id", $id) -> firstOrFail();
        $leagues = League::get();
        return view("user.UserSeeUser", ["comments" => $comments , "news" => $news, 
        "leagues" => $leagues, "PostAmount" => $post_ammount, "CommentAmount" => $comments_ammount,
        "username"=>$username, "title" => $username->username]);
    }
    public function UserDeleteReplyComment($id){
        CommentsReply::where("id", $id) -> delete();
        return redirect()->back();
    }
    public function UpdateComment(Request $request){
        Comments::where("id", $request -> input("comment_id"))->update([
            "comment" => $request->input("comment")
        ]);
        return redirect()->back();
    }
    public function UserUpdateReplyComments(Request $request){
        CommentsReply::where("id", $request->input("id"))->update([
            "comment" => $request->input("reply_comment")
        ]);
        return redirect()->back();
    }
}
