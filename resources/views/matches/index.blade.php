@extends('layouts.app')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Matches</h1>

        <table class="table table-striped">
            <tbody>

            @foreach($combinations as $combination)
                <tr>
                    @foreach($combination['names'] as $value)
                        <td>{{$value}}</td>
                    @endforeach
                        <td style="border: 1px solid #949499;">{{$combination['average_score'].'%'}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
