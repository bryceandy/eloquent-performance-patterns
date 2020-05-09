@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Club</th>
                    <th scope="col">Last Trip</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $friends as $friend)
                    <tr>
                        <td>
                            {{ $friend->name === auth()->user()->name ? 'You 🙂' : $friend->name }}
                            @if( auth()->user()->buddies->contains($friend) )
                                <span class="badge badge-pill badge-warning">Buddy</span>
                            @endif
                            @if( (auth()->user()->club->id == $friend->club->id) && $friend->id !== auth()->id() )
                                <span class="badge badge-pill badge-success">Club</span>
                            @endif
                        </td>
                        <td>{{ $friend->club->name }}</td>
                        <td>{{ $friend->lastTrip->when_at->diffForHumans() }} <small>({{ $friend->lastTrip->lake }})</small></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $friends->links() }}
</div>
@endsection
