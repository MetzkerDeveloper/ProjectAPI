<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API RestFull com Laravel",
 *     version="1.0",
 *  )
 *  
*/

class UserController extends Controller
{
   /** Get All Users Documentation
    * @OA\Get(
    *   path="/api/users",   
    *   summary="Get all users",
    *   tags={"Users"},
    *   @OA\Response(response="200", 
    *    description="List all users"),
    * ) 
   */
   public function users(){
    $users = User::all();
    return $users;
   }
   /** User by id documentation
    * @OA\Get(
    *   path="/api/users/{id}",   
    *   summary="Get user by id",
    *   tags={"Users"},
    *   @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="The id passed to get data like in query string.",
    *         @OA\Schema(type="string"),
    *   ),
    *   @OA\Response(response="200", 
    *    description="List user by id")
    * ) 
   */
   public function user(Request $request){
            try {
                  $id =  $request->id;
                  if($id){
                     return  User::findOrFail($id);
                  }
                  return;
            } catch (Exception $e) {
               return $e->getMessage();
            }
      }

   /** Created User Documentation 
    * @OA\Post(
    *     path="/api/users",
    *     summary="Create a user",
    *     description="Create a user",
    *     tags={"Users"},
    *     @OA\RequestBody(
    *        @OA\MediaType(
    *          mediaType="multipart/form-data",
    *          @OA\Schema(
    *            @OA\Property(
    *              property="name",
    *              type="string",
    *           ),
    *              @OA\Property(
    *              property="email",
    *              type="string",
    *           ),
    *              @OA\Property(
    *                property="password",
    *                type="string",
    *           ),
    *         ),
    *       ),
    *     ),
    *     @OA\Response(response=200, description="User created successfully"),
    *     @OA\Response(response=404, description="Not Found")
    *  )
   */
   public function create(Request $request){
         try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return ["Status"=>200,
            "Message"=> "User created with successfully." ];
         } catch (Exception $e) {
            return $e->getMessage();
         }
   }

   /** Update Documentation 
    * @OA\Put(
    *     path="/api/users/{id}",
    *     summary="Updates a user",
    *     description="Updates a user",
    *     tags={"Users"},
    *     @OA\RequestBody(
    *        @OA\MediaType(
    *          mediaType="application/json",
    *          @OA\Schema(
    *            @OA\Property(
    *              property="id",
    *              type="integer",
    *           ),
    *              @OA\Property(
    *              property="name",
    *              type="string",
    *           ),
    *              @OA\Property(
    *                property="email",
    *                type="string",
    *           ),
    *         ),
    *       ),
    *     ),
    *     @OA\Response(response=200, description="User updated successfully"),
    *     @OA\Response(response=404, description="User informed does not exist")
    *  )
   */
   public function update(Request $request){
         try {
            $user =  User::findOrFail($request->id);
            if($user){
            $user->name = $request->name;
            $user->email = $request->email;
               $user->save();
         }else{
            return ["Status"=>404,
            "Message"=> "User informed does not exist" ];
         }  
         return ["Status"=>200,
                  "Message"=> "User updated successfully" ];
         } catch (Exception $e) {
            return $e->getMessage();
         }

   }

   /** Delete documentation
    * @OA\Delete(
    *   path="/api/users/{id}",   
    *   summary="Delete user by id",
    *   tags={"Users"},
    *   @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="The id passed to delete data of user in query string.",
    *         @OA\Schema(type="string"),
    *   ),
    *   @OA\Response(response="202", 
    *    description="User deleted with success.")
    * ) 
   */
   public function delete($id){
      $user =  User::findOrFail($id);
      if($user){
         $user->delete();
         return ["Status"=>202,
               "Message"=> "Usuário deletado com sucesso" ];
      }else{
         return ["Status"=>404,
               "Message"=> "Usuário não existe." ];
      }
   }

}
