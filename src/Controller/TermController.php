<?php

namespace OrckidLab\LaravelTaxonomy\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OrckidLab\LaravelTaxonomy\Models\Taxonomy;
use OrckidLab\LaravelTaxonomy\Models\Term;
use OrckidLab\LaravelTaxonomy\View\DefaultTermView;

class TermController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Taxonomy $taxonomy
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Taxonomy $taxonomy)
	{
		if(!$request->has('slug')){
			$request->offsetSet('slug', str_slug($request->label));
		}

		$term = new Term($request->all());

		$taxonomy->terms()->save($term);

		return back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Taxonomy $taxonomy
	 * @param Term $term
	 * @return DefaultTermView
	 */
	public function edit(Taxonomy $taxonomy, Term $term)
	{
		$customView = studly_case($term->taxonomy->slug) . "View";

		$customViewClass = "App\Taxonomy\TermView\\$customView";

		$instance = class_exists($customViewClass) ? new $customViewClass($taxonomy, $term) : new DefaultTermView($taxonomy, $term);

		return $instance->edit();
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
		if(!$request->has('slug')){
			$request->offsetSet('slug', str_slug($request->label));
		}

		$term->update($request->all());

		return redirect(route('taxonomy.edit', ['taxonomy' => $term->taxonomy]));
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
