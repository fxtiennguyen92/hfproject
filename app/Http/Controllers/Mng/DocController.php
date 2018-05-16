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
use App\Doc;

class DocController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'title' => 'required|string|max:150',
						'urlName' => 'required|string|max:45|unique:docs',
						'content' => 'required|string',
		]);
	}

	public function viewList() {
// 		$blogModel = new Blog();
// 		$blogs = $blogModel->getAll();
		
// 		return view(Config::get('constants.MNG_BLOG_LIST_PAGE'), array(
// 						'blogs' => $blogs,
// 		));
	}

	public function newDoc() {
		return view(Config::get('constants.MNG_DOC_PAGE'), array(
			
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', $validator->errors()->first());
		}
		
		try {
			$doc = new Doc();
			
			$doc->url_name = $request->urlName;
			$doc->title = $request->urlName;
			$doc->content = $request->content;

			$doc->save();
			return redirect()->route('mng_doc_list');
		} catch (\Exception $e) {
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
			return Redirect::back()->withInput()->with($e->getMessage(), 500);
		}
	}
}
