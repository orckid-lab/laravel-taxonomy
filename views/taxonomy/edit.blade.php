<p>Editing group {{ $taxonomy->name }}</p>

<table>
	<tr>
		<td>id</td>
		<td>label</td>
		<td>order</td>
		<td></td>
	</tr>
	@foreach($terms as $term)
		<tr>
			<td>{{ $term->id }}</td>
			<td>{{ $term->label }}</td>
			<td>{{ $term->order }}</td>
			<td>
				<a href="{{ route('term.edit', ['term' => $term]) }}">Edit</a>
				<form action="{{ route('term.destroy', ['term' => $term]) }}" method="post">
					{{ csrf_field() }}
					<button type="submit">Delete</button>
				</form>
			</td>
		</tr>
	@endforeach
</table>

@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<form action="{{ route('taxonomy.update', ['taxonomy' => $taxonomy]) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('patch') }}
	<fieldset>
		<label for="label">Label</label>
		<input id="label" type="text" name="label"/>
	</fieldset>
	<fieldset>
		<label for="order">Order</label>
		<input id="order" type="text" name="order"/>
	</fieldset>
	<button type="submit">Add option</button>
</form>