<?php

namespace App\Http\Controllers\Mng;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Doc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocController extends Controller
{
	protected function validator(array $data) {
		return Validator::make($data, [
						'title' => 'required|string|max:150',
						'url_name' => 'required|string|max:45',
						'content' => 'required|string',
		]);
	}

	public function viewList() {
		$docModel = new Doc();
		$docs = $docModel->getAllForMng();
		
		return view(Config::get('constants.MNG_DOC_LIST_PAGE'), array(
						'docs' => $docs,
		));
	}

	public function newDoc() {
		return view(Config::get('constants.MNG_DOC_PAGE'), array(
		));
	}

	public function edit($id) {
		$docModel = new Doc();
		$doc = $docModel->getById($id);
		if (!$doc) {
			throw new NotFoundHttpException();
		}
		
		return view(Config::get('constants.MNG_DOC_PAGE'), array(
						'doc' => $doc
		));
	}

	public function create(Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', $validator->errors()->first());
		}
		
		try {
			$doc = new Doc();
			
			$doc->url_name = $request->url_name;
			$doc->title = $request->title;
			$doc->content = $request->content;
			$doc->updated_by = auth()->user()->id;
			
			$doc->save();
			return redirect()->route('mng_doc_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function update($id, Request $request) {
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return Redirect::back()->withInput()->with('error', $validator->errors()->first());
		}
		
		try {
			$doc = Doc::find($id);
			
			$doc->url_name = $request->url_name;
			$doc->title = $request->title;
			$doc->content = $request->content;
			$doc->updated_by = auth()->user()->id;
			
			$doc->save();
			return redirect()->route('mng_doc_list');
		} catch (\Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	public function delete($id) {
		try {
			Doc::destroy($id);
			
			return response()->json('', 200);
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), 500);
		}
	}
}
