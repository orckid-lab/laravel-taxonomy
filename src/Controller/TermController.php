<?php

namespace OrckidLab\LaravelTaxonomy\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OrckidLab\LaravelTaxonomy\Models\Term;

class TermController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Term $term
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Term $term)
	{
		return view('taxonomy::term.edit')->with([
			'term' => $term
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Term $term
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Term $term)
	{
		$term->update($request->all());

		return redirect(route('taxonomy.edit', ['term' => $term->group]));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Term $option
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Term $option)
	{
		dd($option);
	}
}
