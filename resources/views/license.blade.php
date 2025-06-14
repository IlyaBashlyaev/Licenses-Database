@extends('template')

@section('link')
    <link rel="shortcut icon" href="../icon.png">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
@endsection

@section('title')<title>Overview of the license</title>@endsection

@section('nav')
    <div><a style="color: #fff;">License "{{ $license['name'] }}"</a></div>
    <div class="edit_remove">
        <button onclick="window.location.href = '/license/{{ $id }}/edit'">Edit</button>
        <button onclick="remove()">Delete</button>
    </div>
@endsection

@section('icon')
    <div class="icon" onclick="window.location.href = '/'"><img src="../icon.png"></div>
@endsection

@section ('content')
    <h2 id="licenses"></h2>
    <div class="table-responsive custom-table-responsive licenses-table">
        <table class="table custom-table">
            <tbody>
            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Name:</a></td>
                <td>{{ $license['name'] }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Description:</a></td>
                <td>{{ $license['description'] }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Price:</a></td>
                <td>{{ $license['price'] }} €</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Renewal:</a></td>
                <td>{{ $renovation }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Provider:</a></td>
                <td>{{ $provider }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Client:</a></td>
                <td>{{ $client }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Payment by:</a></td>
                <td>{{ $payment }}
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Start date of the term:</a></td>
                <td>{{ $license['runtime_start'] }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>

            <tr scope="row" style="cursor: pointer;">
                <td><a style="font-weight: 500;">Expected end date:</a></td>
                <td>{{ $runtimeEnd }}</td>
            </tr>
            <tr class="spacer"><td colspan="100"></td></tr>
            </tbody>
        </table>
    </div>

    <h2>Date: <?= date('d.m.Y') ?></h2>
    <form method="post" action="/delete/license/{{ $id }}" style="display: none;"></form>

    <script>
        function remove() {
            const form = document.querySelector('form')
            form.innerHTML = `<input name="_token" value="<?= csrf_token() ?>">
<input name="type" value="license">
<input name="id" value="{{ $id }}">
<button type="submit"></button>`
            form.querySelector('button[type="submit"]').click()
        }
    </script>
@endsection

@section('script')
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
@endsection
