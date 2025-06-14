@extends('template')

@section('link')
    <link rel="shortcut icon" href="../../icon.png">
    <link rel="stylesheet" href="../../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
@endsection

@section('title')
    @if ($id)
        <title>Editing of the license</title>
    @else
        <title>New license</title>
    @endif
@endsection

@section('nav')
    <div><a style="color: #fff;">New license</a></div>
    <div class="edit_remove">
        <button onclick="window.location.href = '/'">Cancel</button>
        <button onclick="add()">Apply</button>
    </div>
@endsection

@section('icon')
    <div class="icon" onclick="window.location.href = '/'"><img src="../../icon.png"></div>
@endsection

@section ('content')
    <h2 id="licenses"></h2>
    <div class="table-responsive custom-table-responsive licenses-table">
        <table class="table custom-table">
            <tbody>
                <tr scope="row" style="cursor: pointer;">
                    <td><b>Name:</b></td>
                    <td><input class="name" placeholder="Name" value="{{ $license['name'] }}"></td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Description:</b></td>
                    <td><input class="description" placeholder="Description" value="{{ $license['description'] }}"></td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Price:</b></td>
                    <td><input type="number" class="price" placeholder="Price (in $)" value="{{ $license['price'] }}"></td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Renewal:</b></td>
                    <td><input type="number" class="renovation_month" placeholder="Renewal (months)" value="{{ $license['renovation_month'] }}"></td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Provider:</b></td>
                    <td>
                        <select id="provider" oninput="checkInput(this, 0)">
                            <option value="">- Please select -</option>
                            @foreach ($providers as $provider)
                                @if ($provider_['id'] == $provider['id'])
                                    <option id="{{ $provider['id'] }}" value="{{ $provider['name'] }}" selected>{{ $provider['name'] }}</option>
                                @else
                                    <option id="{{ $provider['id'] }}" value="{{ $provider['name'] }}">{{ $provider['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Client:</b></td>
                    <td>
                        <select id="client" oninput="checkInput(this, 1)">
                            <option value="">- Please select -</option>
                            @foreach ($clients as $client)
                                @if ($client_['id'] == $client['id'])
                                    <option id="{{ $client['id'] }}" value="{{ $client['name'] }}" selected>{{ $client['name'] }}</option>
                                @else
                                    <option id="{{ $client['id'] }}" value="{{ $client['name'] }}">{{ $client['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Payment by:</b></td>
                    <td>
                        <select id="payment" oninput="checkInput(this, 2)">
                            <option value="">- Please select -</option>
                            @foreach ($payments as $payment)
                                @if ($payment_['id'] == $payment['id'])
                                    <option id="{{ $payment['id'] }}" value="{{ $payment['name'] }}" selected>{{ $payment['name'] }}</option>
                                @else
                                    <option id="{{ $payment['id'] }}" value="{{ $payment['name'] }}">{{ $payment['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>

                <tr scope="row" style="cursor: pointer;">
                    <td><b>Start date of the term:</b></td>
                    <td><input type="date" class="runtime_start" placeholder="Begin der Laufzeit" value="{{ $license['runtime_start'] }}"></td>
                </tr>
                <tr class="spacer"><td colspan="100"></td></tr>
            </tbody>
        </table>
    </div>

    @if ($errors -> any())
        <div id="errors">
            <h2>Fehler!</h2>
            <ul>
                @foreach($errors -> all() as $error)
                    <li style="color: #fff;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <h2>Datum: <?= date('d.m.Y') ?></h2>
    @endif

    <form method="post" action="/add" style="display: none;"></form>

    <script>
        console.log('<?= $_SERVER['REQUEST_URI'] ?>')
        const url = '<?= $_SERVER['REQUEST_URI'] ?>'
        var id = ['{{ $provider_['id'] }}', '{{ $client_['id'] }}', '{{ $payment_['id'] }}'],
            action = '<?php
                if (isset($_GET['id'])) echo 'edit';
                else echo 'add';
            ?>'

        function checkInput(element, type) {
            const options = element.querySelectorAll('option')
            for (var i = 0; i < options.length; i++) {
                if (element.value == options[i].value) {
                    id[type] = options[i].id
                    return
                }
            }
        }

        function add() {
            const form = document.querySelector('form')
            var price = document.querySelector('.price')

            if (price)
                price = parseFloat(price.value).toFixed(2)
            else
                price = ''

            if (url.split('/')[1] == 'license' && url.split('/')[2] == 'add')
                form.action = '/add/license/send'
            else if (url.split('/')[1] == 'license' && url.split('/')[3] == 'edit')
                form.action = '/edit/license/{{ $id }}/send'

            form.innerHTML = form.innerHTML = `<input name="_token" value="<?= csrf_token() ?>">
    <input name="type" value="license">
    <input name="name" value="${document.querySelector('.name') ? document.querySelector('.name').value : ''}">
    <input name="description" value="${document.querySelector('.description') ? document.querySelector('.description').value : ''}">
    <input name="price" value="${price}">
    <input name="renovation_month" value="${document.querySelector('.renovation_month') ? document.querySelector('.renovation_month').value : ''}">
    <input name="provider" value="${id[0]}">
    <input name="client" value="${id[1]}">
    <input name="payment" value="${id[2]}">
    <input name="runtime_start" value="${document.querySelector('.runtime_start') ? document.querySelector('.runtime_start').value : ''}">
    <input name="id" value="{{ $id }}">
    <button type="submit"></button>`
            form.querySelector('button[type="submit"]').click()
        }
    </script>
@endsection

@section('script')
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
@endsection
