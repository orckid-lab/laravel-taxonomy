<p>list of groups</p>
@if($taxonomies->count())
<ul>
	@foreach($taxonomies as $taxonomy)
	<li>
		<a href="{{ route('taxonomy.edit', ['taxonomy' => $taxonomy])  }}">{{ $taxonomy->label }}</a>
	</li>
	@endforeach
</ul>
@else
	<p>No taxonomy.</p>
@endif

@include('taxonomy::_errors')

<p>Add a taxonomy.</p>
<form id="form-add-taxonomy" action="{{ route('taxonomy.store') }}" method="post">
	{{ csrf_field() }}
	<fieldset>
		<label for="label">Label</label>
		<input id="label" type="text" name="label"/>
	</fieldset>
	<button type="submit">Add taxonomy</button>
</form>