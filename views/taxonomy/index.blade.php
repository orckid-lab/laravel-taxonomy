<p>list of groups</p>
@if($taxonomies->count())
<ul>
	@foreach($taxonomies as $taxonomy)
	<li>
		<a href="{{ route('taxonomy.edit', ['taxonomy' => $taxonomy])  }}">{{ $taxonomy->name }}</a>
	</li>
	@endforeach
</ul>
@else
	<p>No taxonomy.</p>
@endif

@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<p>Add a group of options.</p>
<form action="{{ route('taxonomy.store') }}" method="post">
	{{ csrf_field() }}
	<fieldset>
		<label for="name">Name</label>
		<input id="name" type="text" name="name"/>
	</fieldset>
	<button type="submit">Add</button>
</form>