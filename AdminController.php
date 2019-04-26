<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\banUserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
/**
 * Class AdminRolesController
 */
class AdminController extends Controller
{
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function banUser($id, banUserRequest $request)
    {
        // search for user
        $user = \User::find($id);

        //If user not found
        if (!$user) {
            throw new \Exception('User not found');
        }
        //If user not admin
        if ($user->role == config('ADMIN_ROLE')) {
            throw new \Exception('Cannot ban an admin');
        }

        //Set their role and status to banned
        $this->setBannedUserRoleStatus($user);

        //If there was a reason passed in
        if (isset($request->reason) && $request->reason) {
            \UserLog::create([
                'user_id' => $user->id,
                'action'  => 'banned',
                'reason'  =>$request->reason,
            ]);
        } else {
            \UserLog::create([
                'user_id' => $user->id,
                'action'  => 'banned',
            ]);
        }
        //Go back with message
        return Redirect::back()->with('Message', 'User has been banned');
    }

    /* Set user role and status to banned */
    private function setBannedUserRoleStatus(\User $user){
        $user->role = config('BANNED_ROLE');
        $user->status = config('BANNED_STATUS');
        $user->save();
    }
}