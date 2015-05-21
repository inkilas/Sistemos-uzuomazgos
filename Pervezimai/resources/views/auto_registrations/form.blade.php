@if (count($errors) > 0)
	<div class="alert alert-danger">
		Klaida!<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<div class="form-group">

    {!! Form::label('auto_name', 'Automobilio pavadinimas: ') !!}
    {!! Form::text('auto_name', null, ['class' => 'form-control', 'placeholder' => 'Įveskite automobilio pavadinimą']) !!}
    <br/>
    {!! Form::label('category_list', 'Pasirinkite kategorijas: ') !!}
    {!! Form::select('category_list[]', $categories, null, ['id' => 'category_list', 'class' => 'form-control', 'multiple']) !!}
    <br/>
    <br>
    {!! Form::label('country_list', 'Pasirinkite šalis į kurias vežate: ') !!}
    @if(isset($id))
        {!! Form::select('country_list[]', $countries, null, ['id' => 'country_list', 'class' => 'form-control', 'multiple'] ) !!}
    @else
        {!! Form::select('country_list[]', $countries, 16, ['id' => 'country_list', 'class' => 'form-control', 'multiple'] ) !!}
    @endif

    <br/>
    <br/>
    @if(isset($id))
        {!! Form::label('auto_id', 'Pasirinkite automobilio tipą: ') !!}
        {!! Form::select('auto_id', $auto_types, $selected_auto, ['class' => 'btn btn-category dropdown-toggle']) !!}
    @else
        {!! Form::label('auto_id', 'Pasirinkite automobilio tipą: ') !!}
        {!! Form::select('auto_id', $auto_types, 1, ['class' => 'btn btn-category dropdown-toggle']) !!}
    @endif
    <br/>
    <br>
    {!! Form::label('auto_city', 'Automobilio miestas arba adresas: ') !!}
    {!! Form::text('auto_city', null, ['class' => 'form-control', 'placeholder' => 'Įveskite adresą, kuriame automobilis dažniausiai būna']) !!}
    <br>
    {!! Form::label('price_km', 'Įkainis km/eur: ') !!}
    {!! Form::input('number', 'price_km', null, ['class' => 'form-control', 'step' => '0.01']) !!}
    <br>
    {!! Form::label('price_h', 'Įkainis val/eur: ') !!}
    {!! Form::input('number', 'price_h', null, ['class' => 'form-control', 'step' => '0.01']) !!}
    <br>
    {!! Form::label('extra_services', 'Papildomos paslaugos ') !!}
    {!! Form::hidden('extra_services', '0') !!}
    @if(isset($id))
        @if($auto->extra_services == 0)
            {!! Form::checkbox('extra_services', '1') !!}
        @else
            {!! Form::checkbox('extra_services', '1', ['checked']) !!}
        @endif
    @else
        {!! Form::checkbox('extra_services', '1') !!}
    @endif
    <br/>
    {!! Form::label('auto_comment', 'Komentaras: ') !!}
    {!! Form::textarea('auto_comment', null, ['class' => 'form-control', 'placeholder' => 'Įveskite papildomą informaciją apie Jūsų transporto priemonę.']) !!}

</div>
<div class="form-group">
    {!! Form::submit('Išsaugoti', ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('footer')

    <script>
        $('#category_list').select2({
            placeholder: 'Pasirinkite kategoriją'
        });
        $('#country_list').select2();
    </script>
@endsection
