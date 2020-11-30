<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AddNews;
use App\Comments;
use App\League;
use App\Teams;
use App\CommentsReply;

class Guest extends Controller
{
   public function index(){
       $leagues = League::get();
       $news = AddNews::orderBy("created_at", "desc")->paginate(7);
       return view("welcome", ["news" => $news, "leagues" => $leagues, "title"=>"მთავარი გვერდი"]);
   }
   public function show($id){
        $replyComments = CommentsReply::where("post_id", $id)->get();
        $leagues = League::get();
        $news = AddNews::where("id", $id) -> firstOrFail();
        $comments = Comments::where("post_id", $id)->get();
        return view("GuestShow", ["news" => $news , "comments" => $comments, "leagues" => $leagues, 
        "replyComments"=>$replyComments, 
        "title"=>$news->title]);
   }
   public function ShowUSer($id){
        $leagues = League::get();
        $UserPosts = AddNews::orderBy("created_at", "desc")->where("user_id", $id)->paginate(3);
        $UserComments = Comments::orderBy("created_at", "desc")->where("user_id", $id)->paginate(3);
        $count_userPosts = AddNews::where("user_id", $id)->count();
        $count_UserComments = Comments::where("user_id", $id)->count();
        $username = AddNews::select("username")->where("user_id", $id)->firstOrFail();
        return view("ShowUser", ["comments" => $UserComments , "news" => $UserPosts, 
        "leagues" => $leagues, "PostAmount" => $count_userPosts, "CommentAmount" => $count_UserComments,
        "username"=>$username, "title"=>$username->username]);
   }
   public function ShowWithLeague($id){
        $leagues = League::get();
        $teams = Teams::where("LeagueId", $id) -> get();
        $news = AddNews::orderBy("created_at", "desc")->where("league_id", $id) -> paginate(7);
        $league_name = League::select("leagues")->where("id", $id)->firstOrFail();
        return view("ShowWithLeague", ["news" => $news, "teams" => $teams, "leagues" => $leagues,
        "title"=>$league_name->leagues]);
   }
   public function ShowWithTeams($id){
        $leagues = League::get();
        $news = AddNews::orderBy("created_at", "desc")->where("team_id", $id) -> paginate(7);
        $team_name = Teams::select("team")->where("id", $id)->firstOrFail();
        return view("ShowWithTeams", ["leagues" => $leagues, "news" => $news,
        "title" => $team_name->team]);
   }
}
