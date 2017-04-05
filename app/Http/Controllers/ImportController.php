<?php

namespace App\Http\Controllers;

use App\Common;
use App\Scheme;
use App\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
	/**
	 * Show import page
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index() {
		return view('import.index');
	}

	/**
	 * Show confirm page after uploading.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function upload(Request $request) {
		$schemeArr = Scheme::get();

		$path = $request->file('importFile')->store('import');
		$rows = Excel::selectSheetsByIndex(0)->load("storage/app/" . $path)->get();

		return view('import.upload', ['schemeArr' => $schemeArr, 'rows' => $rows, 'path' => $path]);
	}

	/**
	 * Process uploaded file.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function process(Request $request) {
		$path = $request->all()['path'];
		$schemeArr = Scheme::get();
		$rows = Excel::selectSheetsByIndex(0)->load("storage/app/" . $path)->get();
		foreach ($rows as $row) {
			$data = [];
			foreach ($schemeArr as $scheme) {
				$data[$scheme->getAttribute('key')] = $row->get($scheme->getAttribute('key'));
			}
			Species::createWithCurrentUser($data);
		}
		return redirect(route('species.index'));
	}
}
