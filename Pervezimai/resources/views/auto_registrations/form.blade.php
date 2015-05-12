<div class="form-group">
    {!! Form::label('auto_name', 'Automobilio pavadinimas: ') !!}
    {!! Form::text('auto_name', null, ['class' => 'form-control', 'placeholder' => 'Įveskite automobilio pavadinimą']) !!}

        <span style="margin-left: 25px; margin-right: 25px">
            {!! Form::label('category_list', 'Pasirinkite kategorijas: ') !!}

            {!! Form::select('category_list[]', $categories, null, ['id' => 'category_list', 'class' => 'form-control', 'multiple']) !!}
        </span>

    <br/>
    <br/>

        <span style="margin-left: 25px; margin-right: 25px">
            {!! Form::label('country_list', 'Pasirinkite šalis į kurias vežate: ') !!}
            @if(isset($id))
            {!! Form::select('country_list[]', $countries, null, ['id' => 'country_list', 'class' => 'form-control', 'multiple'] ) !!}
            @else
            {!! Form::select('country_list[]', $countries, 16, ['id' => 'country_list', 'class' => 'form-control', 'multiple'] ) !!}
            @endif
        </span>

    <br/>
    <br/>
    {!! Form::label('auto_id', 'Pasirinkite automobilio tipą: ') !!}
    {!! Form::select('auto_id', $auto_types, 1) !!}
    <br/>

    {!! Form::label('auto_city', 'Automobilio miestas arba adresas: ') !!}
    {!! Form::text('auto_city', null, ['class' => 'form-control', 'placeholder' => 'Įveskite miestą, kuriame automobilis dažniausiai būna']) !!}

    {!! Form::label('price_km', 'Įkainis km/eur: ') !!}
    {!! Form::input('number', 'price_km', null, ['class' => 'form-control', 'step' => '0.01']) !!}

    {!! Form::label('price_h', 'Įkainis val/eur: ') !!}
    {!! Form::input('number', 'price_h', null, ['class' => 'form-control', 'step' => '0.01']) !!}

    {!! Form::label('extra_services', 'Papildomos paslaugos ') !!}
    {!! Form::input('checkbox', 'extra_services', '1') !!}
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