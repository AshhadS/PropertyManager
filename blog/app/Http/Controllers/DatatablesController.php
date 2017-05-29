<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Unit;

use Datatables;

class DatatablesController extends Controller
{
	/**
	* Displays datatables front end view
	*
	* @return \Illuminate\View\View
	*/
	public function index()
	{
		return view('test');
	}

	/**
	* Process datatables ajax request.
	*
	* @return \Illuminate\Http\JsonResponse
	*/
	public function anyData()
	{
		return Datatables::of(Unit::query())->make(true);
	}
}
