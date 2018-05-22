<?php

namespace App\Http\Controllers;

use App\User;
use App\Blog;
use App\ProProfile;

class FileController
{
	public static function saveAvatar($data, $userId = null) {
		$fileName = str_random(6).'.png';
		$directoryName = 'u'.'/'. $userId;
		
		if (!$userId) {
			$userId = auth()->user()->id;
		}
		$user = User::where('id', $userId)->first();
		if ($user->avatar) {
			\Storage::delete($directoryName.'/'.$user->avatar);
		}
		
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
		
		$user->avatar = $fileName;
		$user->save();
	}
	
	public static function saveBlogImage($data, $blogId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'img/blog';
		
		$blog = Blog::where('id', $blogId)->first();
		if ($blog->image) {
			\Storage::delete($directoryName.'/'.$blog->image);
		}
		
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
		
		$blog->image = $fileName;
		$blog->save();
	}
	
	public static function deleteBlogImage($blogId) {
		$directoryName = 'img/blog';
		
		$blog = Blog::where('id', $blogId)->first();
		if ($blog->image) {
			\Storage::delete($directoryName.'/'.$blog->image);
		}
	}

	public static function saveCompanyCoverImage($data, $fileName) {
		$directoryName = 'img/comp/cover';
		
		\Storage::delete($directoryName.'/'.$fileName);
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
	}

	public static function saveGovEnvidence($data, $proId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'u'.'/'. $proId;
		
		$pro = ProProfile::where('id', $proId)->first();
		\Storage::delete($directoryName.'/'.$pro->gov_evidence);
		
		$fileSrc = \Storage::put($directoryName.'/'. $fileName, $data);
		
		$pro->gov_evidence = $fileName;
		$pro->save();
	}
}
