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
		$blogs = $blogModel->getAllForMng();
		
		return view(Config::get('constants.MNG_BLOG_LIST_PAGE'), array(
						'blogs' => $blogs,
		));
	}

	public function newBlog() {
		$blogModel = new Blog();
		$categories = $blogModel->getCategories();
		
		return view(Config::get('constants.MNG_BLOG_PAGE'), array(
						'categories' => $categories
		));
	}

	public function edit($id, Request $request) {
		$blogModel = new Blog();
		$blog = $blogModel->getById($id);
		if (!$blog) {
			throw new NotFoundHttpException();
		}
		
		$categories = $blogModel->getCategories();
		
		return view(Config::get('constants.MNG_BLOG_PAGE'), array(
						'blog' => $blog,
						'categories' => $categories
		));
	}

	public function updateOrCreate($id = null, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		// no image for new blog
		if (!$id && !$request->image) {
			return Redirect::back()->withInput()->with('error', 400);
		}
		
		try {
			DB::beginTransaction();
			$blog = Blog::updateOrCreate([
					'id' => $id
			],[
					'title' => $request->title,
					'url_name' => $request->urlName,
					'category' => $request->category,
					'content' => $request->content,
					'updated_by' => auth()->user()->id
			]);
			
			if (!$id || ($id && $request->image)) {
				// save image - special case
				$image = $request->image;
				$baseToPhp = explode(',', $image); // remove the "data:image/png;base64,"
				if (sizeof($baseToPhp) == 2) {
					$data = base64_decode($baseToPhp[1]);
					FileController::saveBlogImage($data, $blog->id);
				}
			}
			
			DB::commit();
			return redirect()->route('mng_blog_list');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete($id) {
		try {
			DB::beginTransaction();
			FileController::deleteBlogImage($id);
			Blog::destroy($id);
			
			DB::commit();
			return redirect()->route('mng_blog_list');
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function highlight($id) {
		Blog::updateHighlightFlg($id, Config::get('constants.FLG_ON'), auth()->user()->id);
		return redirect()->route('mng_blog_list');
	}

	public function unhighlight($id) {
		Blog::updateHighlightFlg($id, Config::get('constants.FLG_OFF'), auth()->user()->id);
		return redirect()->route('mng_blog_list');
	}
}
