@extends('app')

@section('content')
    <div class="container">
        <h1>Pateikite užsakymo duomenis</h1>
        <hr/>
        {!! Form::open(['url' => 'orders/search']) !!}
            <div class="form-group">
                {!! Form::label('category_id', 'Pasirinkite pervežimo kategoriją: ') !!}
                {!! Form::select('category_id', $categories, 1, ['required', 'class' => 'btn btn-category dropdown-toggle']) !!}
                <br/>
                {!! Form::label('pickup_address', 'Paėmimo šalis ir adresas: ') !!}
                <div class="row">
                    <div class="col-sm-2">
                    {!! Form::select('pickup_country', $countries, 16, ['id' => 'country_list', 'class' => 'form-control'] ) !!}
                    </div>
                    <div class="col-sm-10">
                        {!! Form::text('pickup_address', null, ['class' => 'form-control', 'placeholder' => 'Gatvė, namo numeris, Miestas']) !!}
                    </div>
                </div>
                {!! Form::label('deliver_address', 'Pristatymo šalis ir adresas: ') !!}
                <div class="row">
                    <div class="col-sm-2">
                    {!! Form::select('deliver_country', $countries, 16, ['id' => 'country_list', 'class' => 'form-control'] ) !!}
                    </div>
                    <div class="col-sm-10">
                        {!! Form::text('deliver_address', null, ['class' => 'form-control', 'placeholder' => 'Gatvė, namo numeris, Miestas']) !!}
                    </div>
                </div>

                {!! Form::label('order_date', 'Paėmimo data: ') !!}
                {!! Form::input('date', 'order_date', date('Y-m-d'), ['class' => 'form-control']) !!}

                {!! Form::label('extra_services', 'Papildomos paslaugos ') !!}
                {!! Form::input('checkbox', 'extra_services', '1') !!}

                <br/>
                {!! Form::label('order_comment', 'Komentaras: ') !!}
                {!! Form::textarea('order_comment', null, ['class' => 'form-control', 'placeholder' => 'Įveskite papildomus duomenis apie krovinį ir jo paėmimo bei pristatymo papildomus poreikius.']) !!}

                {!! Form::hidden('order_key', $number) !!}

            </div>
            <div class="form-group">
                {!! Form::submit('Ieškoti vežėjų', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('footer')

    <script>
        $('#country_list').select2();
    </script>

@endsection