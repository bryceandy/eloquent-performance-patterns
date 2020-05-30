@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form
                    class="form-inline mt-2 mb-5 w-75"
                    method="POST"
                    action="{{route('search-user')}}"
                >
                    @csrf
                    <input
                        class="form-control mr-sm-2"
                        style="width: 80%;"
                        type="search"
                        placeholder="Search user"
                        aria-label="Search"
                        name="search"
                    />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Club</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->club->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>
@endsection
