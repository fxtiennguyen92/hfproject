<?php

namespace App\Http\Controllers;

use App\User;

class FileController
{
	public static function saveAvatar($data, $userId = null) {
		if (!$userId) {
			$userId = auth()->user()->id;
		}
		
		$fileName = str_random(6).'.png';
		
		$directoryName = 'u/'. $userId;
		$directory = \Storage::allDirectories($directoryName);
		if(empty($directory)) {
			\Storage::makeDirectory($directoryName);
		}
		
		$user = User::where('id', $userId)->first();
		
		if ($user->avatar) {
			\Storage::delete($directoryName.'/'.$user->avatar);
		}
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
		
		$user->avatar = $fileName;
		$user->save();
	}
}
