@extends('app')

@section('content')

<<<<<<< HEAD

    <h1>Vežėjų paieška</h1>
    <hr/>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Automobilis</th>
                <th>Vežėjas</th>
                <th>Adresas</th>
            </tr>
        </thead>
        <tbody>
        @foreach($autos_by_categories as $auto_by_category)
            <tr>
                @foreach($auto_by_category->user()->get() as $provider_by_category)
                        <td><input type="hidden" value="{{ $auto_by_category->id }}">{{ $auto_by_category->auto_name }}</td>
                        <td>{{ $provider_by_category->name }}</td>
                        <td>{{ $provider_city = $auto_by_category->auto_city }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>


=======
<div class="container">
    <div class="well well-lg text-center">
        <h1>Vežėjų paieška</h1>
    </div>
    <div class="row">
        <div class="col-sm-8">
        
        </div>
        <div class="col-sm-4">
            {!! Form::open(['url' => 'orders']) !!}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Automobilis</th>
                        <th>Vežėjas</th>
                        <th>Adresas</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($autos_by_categories as $auto_by_category)
                    <tr>
                        @foreach($auto_by_category->user()->get() as $provider_by_category)
                            {!! Form::hidden('', $auto_by_category->id, ['id' => 'auto_registration_id']) !!}
                            {!! Form::hidden('', $provider_by_category->id, ['id' => 'provider_id']) !!}
                            <td>{{ $provider_by_category->name }}</td>
                            <td>{{ $auto_by_category->auto_name }}</td>
                            <td>{{ $auto_by_category->auto_city }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Pateikti užsakymą', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
</div>
>>>>>>> origin/Dainius
@endsection
@section('footer')
<script type="text/javascript">

    $('table td').on('click', function() {
        if($(this).parent().hasClass('success')){
            $(this).parent().removeClass('success');
            $(this).parent().find('input').removeAttr('name');
        }else{
            $(this).parent().addClass('success');
            $(this).parent().find('#auto_registration_id').attr('name', 'auto_registration_id[]');
            $(this).parent().find('#provider_id').attr('name', 'provider_id[]');
        }
    })
</script>
@endsection