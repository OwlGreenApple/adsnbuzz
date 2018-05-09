@extends('layouts.app')

@section('content')
<div class="container" id="isiform">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">User Management</div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead align="center">
                            <th>User ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Max Spend</th>
                            <th>Deposit</th>
                            <th>Login</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>Rp. <?php echo number_format($user->spend_month) ?></td>
                                <td>Rp. <?php echo number_format($user->deposit) ?></td>
                                <td align="center">
                                    <form action="{{url('/manage-user/login/'.$user->id)}}" method="post"> @csrf
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection