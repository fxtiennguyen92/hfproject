<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use App\Blog;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'title' => 'required|string|max:150',
						'urlName' => 'required|string|max:150',
						'content' => 'required|string',
		]);
	}

	public function viewList() {
		$blogModel = new Blog();
		$blogs = $blogModel->getAll();
		
		return view(Config::get('constants.MNG_BLOG_LIST_PAGE'), array(
						'blogs' => $blogs,
		));
	}

	public function view($urlName = null, $error = null, Request $request) {
		if (!$urlName) {
			$request->session()->forget('blog');
			
			return view(Config::get('constants.MNG_BLOG_PAGE'), array(
			));
		}
		
		$blogModel = new Blog();
		$blog = $blogModel->getByUrlName($urlName);
		if (!$blog) {
			throw new NotFoundHttpException();
		}
		
		$request->session()->put('blog', $blog->id);
		
		return view(Config::get('constants.MNG_BLOG_PAGE'), array(
						'blog' => $blog,
		));
	}

	public function post(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		$blogId = null;
		if ($request->session()->has('blog')) {
			$blogId = $request->session()->get('blog');
		}
		
		// no image for new blog
		if (!$blogId && !$request->image) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		try {
			DB::beginTransaction();
			$blog = Blog::updateOrCreate([
					'id' => $blogId
			],[
					'title' => $request->title,
					'url_name' => $request->urlName,
					'style' => $request->style,
					'content' => $request->content,
			]);
			
			if (!$blogId || ($blogId && $request->image)) {
				// save image - special case
				$image = $request->image;
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveBlogImage($data, $blog->id);
				}
			}
			
			DB::commit();
			return redirect()->route('mng_blog_list_page');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete(Request $request) {
		if (!$request->session()->has('blog')) {
			throw new NotFoundHttpException();
		}
		$blogId = $request->session()->get('blog');

		try {
			DB::beginTransaction();
			FileController::deleteBlogImage($blogId);
			Blog::destroy($blogId);
			
			DB::commit();
			return redirect()->route('mng_blog_list_page');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}
}
