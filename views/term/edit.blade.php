<form action="{{ route('term.update', ['term' => $term]) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('patch') }}
	<fieldset>
		<label for="label">Label</label>
		<input id="label" type="text" name="label" value="{{ $term->label }}"/>
	</fieldset>
	<fieldset>
		<label for="order">Order</label>
		<input id="order" type="text" name="order" value="{{ $term->order }}"/>
	</fieldset>
	<button type="submit">Update</button>
</form>