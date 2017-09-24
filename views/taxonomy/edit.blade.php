@extends('taxonomy::layout')

@section('content')
	@include('taxonomy::_errors')

	<form id="form-edit-taxonomy" action="{{ route('taxonomy.update', ['taxonomy' => $taxonomy]) }}" method="post">
		{{ csrf_field() }}
		{{ method_field('patch') }}
		<fieldset>
			<label for="slug">Slug</label>
			<input id="slug" type="text" name="slug" value="{{ $taxonomy->slug }}"/>
		</fieldset>
		<fieldset>
			<label for="label">Label</label>
			<input id="label" type="text" name="label" value="{{ $taxonomy->label }}"/>
		</fieldset>
		<button type="submit">Update taxonomy</button>
	</form>

	<p>Editing taxonomy {{ $taxonomy->label }}</p>

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
				<td>{{ $term->slug }}</td>
				<td>{{ $term->active }}</td>
				<td>{{ $term->order }}</td>
				<td>
					<a href="{{ route('term.edit', ['taxonomy' => $taxonomy, 'term' => $term]) }}">Edit</a>
					<form action="{{ route('term.destroy', ['term' => $term]) }}" method="post">
						{{ csrf_field() }}
						<button type="submit">Delete</button>
					</form>
				</td>
			</tr>
		@endforeach
	</table>

	@include('taxonomy::_errors')

	<form id="form-add-term" action="{{ route('term.store', ['taxonomy' => $taxonomy]) }}" method="post">
		{{ csrf_field() }}
		<fieldset>
			<label for="label">Label</label>
			<input id="label" type="text" name="label"/>
		</fieldset>
		<fieldset>
			<label for="slug">Slug</label>
			<input id="slug" type="text" name="slug"/>
		</fieldset>
		<fieldset>
			<label for="order">Order</label>
			<input id="order" type="text" name="order"/>
		</fieldset>
		<button type="submit">Add term</button>
	</form>
@endsection