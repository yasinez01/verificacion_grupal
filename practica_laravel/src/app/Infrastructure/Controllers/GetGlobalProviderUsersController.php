<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetGlobalProviderUsersController extends BaseController
{
    private UserDataSource $userDataSource;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }
    public function __invoke(): JsonResponse
    {
        $arrayuser= $this->userDataSource->getAll();
        $global_email=false;
        foreach ($arrayuser as $user ){
            $useremailseparate = explode("@",$user->getEmail());
            if ((str_starts_with($useremailseparate[1], 'gmail')) || ((str_starts_with($useremailseparate[1], 'hotmail')))) $global_email=true;
        }
        if($global_email){
            return response()->json([
                [
                    'id' => '1',
                    'email' => 'email@gmail.com',
                ],[
                    'id' => '2',
                    'email' => 'otro_email@hotmail.com',
                ]], Response::HTTP_OK);
        }
        return response()->json([
        ], Response::HTTP_OK);
    }
}
