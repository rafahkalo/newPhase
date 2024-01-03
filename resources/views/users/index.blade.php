@extends('layouts.app')

@section('content')
    @if(session()->has('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>

        .alert-success {
            color: #154784;
            background-color: #f1aeb5;
            border-color: #c3e6cb;
        }


        #success-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

    <script>
        setTimeout(function() {
            $('#success-message').fadeOut('fast', function() {
                $(this).remove();
            });
        }, 3000); // 3 seconds
    </script>
    <head>
        <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">

            <!-- Following -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> All Users </h2>
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                        <th>User</th>
                        <th> </th>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td clphpass="table-text"><div>{{ $user->name }}</div></td>
                                @if (auth()->user()->isFollowing($user->id))
                                    <td>
                                        <form action="{{ route('unfollow', ['user' => $user]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-follow-{{ $user->id }}" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Unfollow
                                            </button>
                                        </form>

                                    </td>
    @else<td>
                                    <form action="{{ route('follow', ['user' => $user]) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit" id="follow-user-{{ $user->id }}" class="btn btn-success">
                                            <i class="fa fa-btn fa-user"></i>Follow
                                        </button>

                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
