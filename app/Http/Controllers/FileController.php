<?php

namespace App\Http\Controllers;

use App\User;

class FileController
{
	public static function saveAvatar($data) {
		$fileName = str_random(6).'.png';
		
		$directoryName = 'u/'. auth()->user()->id;
		$directory = \Storage::allDirectories($directoryName);
		if(empty($directory)) {
			\Storage::makeDirectory($directoryName);
		}
		
		if (auth()->user()->avatar) {
			\Storage::delete($directoryName.'/'.auth()->user()->avatar);
		}
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
		
		$user = User::where('id', auth()->user()->id)->first();
		$user->avatar = $fileName;
		$user->save();
	}
}
