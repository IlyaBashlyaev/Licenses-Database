@extends('template')

@section('link')
    @if (Route::current()->getName() == 'add' || Route::current()->getName() == 'edit')
        <link rel="shortcut icon" href="../../icon.png">
        <link rel="stylesheet" href="../../css/owl.carousel.min.css">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css">
    @else
        <link rel="shortcut icon" href="icon.png">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    @endif
@endsection

@section('title')<title>Licenses Database</title>@endsection

@section('nav')
    <div><a href="#license">Licenses</a><a href="/license/add" class="add">+</a></div>
    <div><a href="#provider">Providers</a><a class="add" onclick="window.location.href = '/add/provider#provider'">+</a></div>
    <div><a href="#client">Clients</a><a class="add" onclick="window.location.href = '/add/client#client'">+</a></div>
    <div><a href="#payment">Payments</a><a class="add" onclick="window.location.href = '/add/payment#payment'">+</a></div>
@endsection

@section('icon')
    @if (Route::current()->getName() == 'add' || Route::current()->getName() == 'edit')
        <div class="icon" onclick="window.location.href = '/'"><img src="../../icon.png"></div>
    @else
        <div class="icon" onclick="window.location.href = '/'"><img src="icon.png"></div>
    @endif
@endsection

@section('content')
    <h2 id="license">Licences</h2>
    <div class="table-responsive custom-table-responsive licenses-table">
        <table class="table custom-table">
            <thead>
                <tr><th scope="col">Name</th></tr>
            </thead>

            <tbody>
                <?php $i = 1 ?>

                @foreach ($licenses as $license)
                    <tr scope="row" style="cursor: pointer;" onclick="window.location.href = `/license/{{ $license['id'] }}`">
                        <td><?= $i ?>) {{ $license['name'] }}</td>
                    </tr>
                    <tr class="spacer"><td colspan="100"></td></tr>
                    <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="provider">Providers</h2>
    <div class="table-responsive custom-table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th scope="col">
                        <label class="control control--checkbox" style="opacity: 0;">
                            <input type="checkbox">
                            <div class="control__indicator"></div>
                        </label>
                    </th>

                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Link</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($providers as $provider)
                    <tr scope="row">
                        <th scope="row">
                            <label class="control control--checkbox">
                                <input type="checkbox" id="{{ $provider -> id }}" class="provider" onchange="edit_delete(this)">
                                <div class="control__indicator"></div>
                            </label>
                        </th>

                        <td>{{ $provider -> name }}</td>
                        <td>{{ $provider -> description }}</td>
                        <td><a href="{{ $provider -> link }}" style="color: #fff;">{{ $provider -> link }}</a></td>
                    </tr>
                    <tr class="spacer"><td colspan="100"></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="client">Clients</h2>
    <div class="table-responsive custom-table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th scope="col">
                        <label class="control control--checkbox" style="opacity: 0;">
                            <input type="checkbox">
                            <div class="control__indicator"></div>
                        </label>
                    </th>

                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Link</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clients as $client)
                    <tr scope="row">
                        <th scope="row">
                            <label class="control control--checkbox">
                                <input type="checkbox" id="{{ $client -> id }}" class="client" onchange="edit_delete(this)">
                                <div class="control__indicator"></div>
                            </label>
                        </th>

                        <td>{{ $client -> name }}</td>
                        <td>{{ $client -> description }}</td>
                        <td><a href="{{ $client -> link }}" style="color: #fff;">{{ $client -> link }}</a></td>
                    </tr>
                    <tr class="spacer"><td colspan="100"></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="payment">Payments</h2>
    <div class="table-responsive custom-table-responsive">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th scope="col">
                        <label class="control control--checkbox" style="opacity: 0;">
                            <input type="checkbox">
                            <div class="control__indicator"></div>
                        </label>
                    </th>

                    <th scope="col">Name</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($payments as $payment)
                    <tr scope="row">
                        <th scope="row">
                            <label class="control control--checkbox">
                                <input type="checkbox" id="{{ $payment -> id }}" class="payment" onchange="edit_delete(this)">
                                <div class="control__indicator"></div>
                            </label>
                        </th>

                        <td>{{ $payment -> name }}</td>
                    </tr>
                    <tr class="spacer"><td colspan="100"></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($errors -> any())
        <div id="errors">
            <h2>Error!</h2>
            <ul>
                @foreach($errors -> all() as $error)
                    <li style="color: #fff;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <h2>Date: <?= date('d.m.Y') ?></h2>
    @endif

    <form method="post" style="display: none;"></form>

    @if ($type)
        @if (Route::current()->getName() == 'add')
            <script>
                var navFixed = false
                const type = '{{ $type }}', typeId = '{{ $typeId }}',
                      table = document.querySelectorAll('.table-responsive.custom-table-responsive')[typeId],
                      rows = table.querySelector('tbody'),
                      nav = document.querySelector('nav')

                if (type == 'provider') {
                    rows.innerHTML += `<tr scope="row">
                        <th scope="row"></th>
                        <td><input class="name" placeholder="Name"></td>
                        <td><input class="description" placeholder="Description"></td>
                        <td><input class="link" placeholder="Link"></td>
                    </tr>`
                    nav.querySelectorAll('div')[1].innerHTML = `<a href="#provider">Providers</a><button onclick="window.location.href = '/'">Cancel</button><button onclick="add(\'provider\')">Apply</button>`
                }

                else if (type == 'client') {
                    rows.innerHTML += `<tr scope="row">
                        <th scope="row"></th>
                        <td><input class="name" placeholder="Name"></td>
                        <td><input class="description" placeholder="Description"></td>
                        <td><input class="link" placeholder="Link"></td>
                    </tr>`
                    nav.querySelectorAll('div')[2].innerHTML = `<a href="#client">Clients</a><button onclick="window.location.href = '/'">Cancel</button><button onclick="add(\'client\')">Apply</button>`
                }

                else if (type == 'payment') {
                    rows.innerHTML += `<tr scope="row">
                        <th scope="row"></th>
                        <td><input class="name" placeholder="Name"></td>
                    </tr>`
                    nav.querySelectorAll('div')[3].innerHTML = `<a href="#payment">Payments</a><button onclick="window.location.href = '/'">Cancel</button><button onclick="add(\'payment\')">Apply</button>`
                }

                document.querySelectorAll('.add').forEach(add => add.onclick = '')
                nav.style.display = 'flex'
            </script>
        @elseif (Route::current()->getName() == 'edit')
            <script>
                var navFixed = false
                const type = '{{ $type }}', id = '{{ $id }}'
                document.querySelectorAll('.' + type).forEach(checkbox => {
                    if (checkbox.id == id)
                        row = checkbox.parentNode.parentNode.parentNode
                })
                const td = row.querySelectorAll('td')

                if (type == 'provider') {
                    row.innerHTML = `<th scope="row"></th>
                    <td><input class="name" placeholder="Name" value="${td[0].innerText}"></td>
                    <td><input class="description" placeholder="Description" value="${td[1].innerText}"></td>
                    <td><input class="link" placeholder="Link" value="${td[2].innerText}"></td>`
                }

                else if (type == 'client') {
                    row.innerHTML = `<th scope="row"></th>
                    <td><input class="name" placeholder="Name" value="${td[0].innerText}"></td>
                    <td><input class="description" placeholder="Description" value="${td[1].innerText}"></td>
                    <td><input class="link" placeholder="Link" value="${td[2].innerText}"></td>`
                }

                else if (type == 'payment')
                    row.innerHTML = `<th scope="row"></th><td><input class="name" placeholder="Name" value="${td[0].innerText}"></td>`

                document.querySelectorAll('.add').forEach(add => add.onclick = '')
                document.querySelector('nav').innerHTML += `<div class="edit_delete"><button onclick="window.location.href = '/'">Cancel</button><button onclick="edit('${type}', '${id}')">Apply</button></div>`
            </script>
        @endif
    @else
        <script>var navFixed = true</script>
    @endif

    <script>
        function add(type) {
            const form = document.querySelector('form')
            form.action = `/add/${type}/send`
            form.innerHTML = `<input name="_token" value="<?= csrf_token() ?>">
    <input name="type" value="${type}">
    <input name="name" value="${document.querySelector('.name') ? document.querySelector('.name').value : ''}">
    <input name="short_name" value="${document.querySelector('.short_name') ? document.querySelector('.short_name').value : ''}">
    <input name="description" value="${document.querySelector('.description') ? document.querySelector('.description').value : ''}">
    <input name="domain" value="${document.querySelector('.domain') ? document.querySelector('.domain').value : ''}">
    <input name="link" value="${document.querySelector('.link') ? document.querySelector('.link').value : ''}">
    <button type="submit"></button>`
            form.querySelector('button[type="submit"]').click()
        }

        function edit_delete(element) {
            const nav = document.querySelector('nav'),
                  editRemove = document.querySelector('.edit_delete')
            checked = false

            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                if ((checkbox.id != element.id || checkbox.className != element.className) && checkbox.checked)
                    checkbox.checked = false
                if (checkbox.checked)
                    checked = true
            })

            if (editRemove)
                editRemove.remove()

            if (checked) {
                nav.innerHTML += `<div class="edit_delete">
        <button onclick="window.location.href = '/edit/${element.className}/${element.id}#${element.className}'">Bearbeiten</button>
        <button onclick="remove('${element.className}', '${element.id}')">Löschen</button>
    </div>`
                navFixed = false
                nav.style.display = 'flex'
            }

            else {
                navFixed = true
                if (window.scrollY == 0)
                    nav.style.display = 'flex'
                else
                    nav.style.display = 'none'
            }
        }

        function edit(type, id) {
            const form = document.querySelector('form')
            form.action = `/edit/${type}/${id}/send`
            form.innerHTML = `<input name="_token" value="<?= csrf_token() ?>">
    <input name="type" value="${type}">
    <input name="id" value="${id}">
    <input name="name" value="${document.querySelector('.name') ? document.querySelector('.name').value : ''}">
    <input name="short_name" value="${document.querySelector('.short_name') ? document.querySelector('.short_name').value : ''}">
    <input name="description" value="${document.querySelector('.description') ? document.querySelector('.description').value : ''}">
    <input name="domain" value="${document.querySelector('.domain') ? document.querySelector('.domain').value : ''}">
    <input name="link" value="${document.querySelector('.link') ? document.querySelector('.link').value : ''}">
    <button type="submit"></button>`
            form.querySelector('button[type="submit"]').click()
        }

        function remove(type, id) {
            const form = document.querySelector('form')
            form.action = `/delete/${type}/${id}`
            form.innerHTML = `<input name="_token" value="<?= csrf_token() ?>">
    <input name="type" value="${type}">
    <input name="id" value="${id}">
    <button type="submit"></button>`
            form.querySelector('button[type="submit"]').click()
        }
    </script>
@endsection

@section('script')
    @if (Route::current()->getName() == 'add' || Route::current()->getName() == 'edit') { ?>
        <script src="../../js/jquery-3.3.1.min.js"></script>
        <script src="../../js/popper.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    @else
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    @endif
@endsection
