<?php

namespace OrckidLab\LaravelTaxonomy\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OrckidLab\LaravelTaxonomy\Taxonomies;
use OrckidLab\LaravelTaxonomy\Models\Term;
use OrckidLab\LaravelTaxonomy\Models\Taxonomy;

class TaxonomyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('taxonomy::taxonomy.index')->with([
			'taxonomies' => Taxonomy::all(),
		]);
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
		$this->validate($request, [
			'name' => 'unique:taxonomies',
		]);

		Taxonomies::create($request->name);

		return back();
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
	 * @param Taxonomy $taxonomy
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Taxonomy $taxonomy)
	{
		return view('taxonomy::taxonomy.edit')->with([
			'taxonomy' => $taxonomy,
			'terms' => $taxonomy->terms()->orderBy('order', 'asc')->get(),
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Taxonomy $taxonomy
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Taxonomy $taxonomy)
	{
		$taxonomy->terms()->save(new Term($request->only(['label', 'order'])));

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
