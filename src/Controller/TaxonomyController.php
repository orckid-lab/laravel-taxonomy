<?php

namespace OrckidLab\LaravelTaxonomy\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OrckidLab\LaravelTaxonomy\Models\Taxonomy;
use OrckidLab\LaravelTaxonomy\Taxonomies;
use OrckidLab\LaravelTaxonomy\View\DefaultTaxonomyView;
use OrckidLab\LaravelTaxonomy\View\TaxonomyView;

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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(!$request->has('slug')){
			$request->offsetSet('slug', str_slug($request->label));
		}

		$this->validate($request, [
			'label' => 'required',
			'slug' => 'required|unique:taxonomies'
		]);

		Taxonomies::create($request->label, $request->slug);

		return back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Taxonomy $taxonomy
	 * @return TaxonomyView
	 */
	public function edit(Taxonomy $taxonomy)
	{
		$customView = studly_case($taxonomy->slug) . "View";

		$customViewClass = "App\Taxonomy\TaxonomyView\\$customView";

		$instance = class_exists($customViewClass) ? new $customViewClass($taxonomy) : new DefaultTaxonomyView($taxonomy);

		return $instance->edit();
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
		if(!$request->has('slug')){
			$request->offsetSet('slug', str_slug($request->label));
		}

		$this->validate($request, [
			'label' => 'required',
			'slug' => [
				'required',
				Rule::unique('taxonomies')->ignore($taxonomy->id),
			]
		]);

		$taxonomy->update($request->all());

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
