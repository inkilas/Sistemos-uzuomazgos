@extends('app')

@section('content')


    <h1>Vežėjų paieška</h1>
    <hr/>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Automobilis</th>
                <th>Vežėjas</th>
            </tr>
        </thead>
        <tbody>
        @foreach($autos_by_categories as $auto_by_category)
            <tr>
                @foreach($auto_by_category->user()->get() as $provider_by_category)
                        <td><input type="hidden" value="{{ $auto_by_category->id }}">{{ $auto_by_category->auto_name }}</td>
                        <td>{{ $provider_by_category->name }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
@section('footer')
<script type="text/javascript">

    $('table td').on('click', function() {
        if($(this).parent().hasClass('success')){
            $(this).parent().removeClass('success');
            $(this).parent().find('input').removeAttr('name');
        }else{
            $(this).parent().addClass('success');
            $(this).parent().find('input').attr('name', 'provider_id[]');
        }
    })
</script>
@endsection