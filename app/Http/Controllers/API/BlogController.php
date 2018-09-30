<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	const ROWS_PER_PAGE = 4;
	
	public function viewCategoryList() {
		$categories = Blog::api_getCategoryList();
		if (sizeof($categories) > 0) {
			return response()->json($categories, 200);
		}
		
		return response()->json(null, 400);
	}
	
	public function viewList(Request $request) {
		$page = $request->get('page');
		if (!$page) {
			$page = 1;
		}
		
		$blogs = Blog::api_getTop($page, $this::ROWS_PER_PAGE);
		if (sizeof($blogs) > 0) {
			return response()->json($blogs, 200);
		}
		
		return response()->json(null, 400);
	}
	
	public function view($url) {
		$blog = Blog::api_get($url);
		if ($blog) {
			return response()->json($blog, 200);
		}
		
		return response()->json(null, 400);
	}
}
