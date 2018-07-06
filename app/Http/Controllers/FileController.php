<?php

namespace App\Http\Controllers;

use App\User;
use App\Blog;
use App\ProProfile;
use App\Service;
use Illuminate\Support\Facades\Storage;

class FileController
{
	public static function saveAvatar($data, $userId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'u'.'/'. $userId;
		
		$user = User::where('id', $userId)->first();
		if ($user->avatar) {
			Storage::delete($directoryName.'/'.$user->avatar);
		}
		
		$fileSrc = Storage::put($directoryName.'/'. $fileName, $data);
		
		$user->avatar = $fileName;
		$user->save();
	}
	
	public static function saveBlogImage($data, $blogId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'img/blog';
		
		$blog = Blog::where('id', $blogId)->first();
		if ($blog->image) {
			Storage::delete($directoryName.'/'.$blog->image);
		}
		
		$fileSrc = Storage::put($directoryName.'/'. $fileName, $data);
		
		$blog->image = $fileName;
		$blog->save();
	}
	
	public static function deleteBlogImage($blogId) {
		$directoryName = 'img/blog';
		
		$blog = Blog::where('id', $blogId)->first();
		if ($blog->image) {
			Storage::delete($directoryName.'/'.$blog->image);
		}
	}

	public static function saveCompanyCoverImage($data, $fileName) {
		$directoryName = 'img/comp/cover';
		
		Storage::delete($directoryName.'/'.$fileName);
		$fileSrc = Storage::put($directoryName.'/'. $fileName, $data);
	}

	public static function saveGovEnvidence($data, $proId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'u'.'/'. $proId;
		
		$pro = ProProfile::where('id', $proId)->first();
		Storage::delete($directoryName.'/'.$pro->gov_evidence);
		
		$fileSrc = Storage::put($directoryName.'/'. $fileName, $data);
		
		$pro->gov_evidence = $fileName;
		$pro->save();
	}
	
	public static function saveServiceImage($data, $serviceId) {
		$fileName = str_random(6).'.png';
		$directoryName = 'img/service';
		
		$service = Service::where('id', $serviceId)->first();
		if ($service->image) {
			Storage::delete($directoryName.'/'.$service->image);
		}
		
		$fileSrc = Storage::put($directoryName.'/'. $fileName, $data);
		
		$service->image = $fileName;
		$service->save();
	}
}
