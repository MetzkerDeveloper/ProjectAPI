<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function users(){
    $users = User::all();
    return $users;
   }

   public function user($id){
    
        $user = User::findOrFail($id);
        if ($user) {
            return $user;
        } else {
            return [
                "Status" => 404,
                "Message" => "Usuário informado não existe."
            ];
        }
    
   }

   public function update(Request $request,$id){
    $user =  User::findOrFail($id);
     if($user){
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
     }else{
        return "Usuário informado não existe";
     }  

     return ["Status"=>202,
             "Message"=> "Usuário atualizado com sucesso" ];
   }

   public function delete($id) {
    $user =  User::findOrFail($id);
    $user->delete();

    return ["Status"=>202,
             "Message"=> "Usuário deletado com sucesso" ];
   }

}
