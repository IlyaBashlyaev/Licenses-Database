<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Licenses;
use App\Models\Clients;
use App\Models\Payments;
use App\Models\Providers;

class MainController extends Controller {
    private $password = '641e65e9a91922db544fd9d171460e38';

    public function main() {
        return view('main', [
            'licenses' => Licenses::get(['id', 'name']), 'providers' => Providers::all(),
            'clients' => Clients::all(), 'payments' => Payments::all(), 'type' => ''
        ]);
    }

    public function add($type) {
        if (Session::get('password') == $this -> password) {
            if ($type == 'provider')
                $typeId = 1;
            else if ($type == 'client')
                $typeId = 2;
            else if ($type == 'payment')
                $typeId = 3;

            return view('main', [
                'licenses' => Licenses::get(['id', 'name']), 'type' => $type, 'typeId' => $typeId,
                'providers' => Providers::all(), 'clients' => Clients::all(), 'payments' => Payments::all()
            ]);
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }
    public function addSend(Request $request, $type) {
        if (Session::get('password') == $this -> password) {
            if ($request -> input('_token') && $type == $request -> input('type')) {
                if ($request -> input('type') == 'license') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'price' => 'required|decimal:2',
                        'renovation_month' => 'required|integer',
                        'provider' => 'required|integer',
                        'client' => 'required|integer',
                        'payment' => 'required|integer',
                        'runtime_start' => 'required'
                    ]);

                    $runtimeStart = explode('-', $request -> input('runtime_start'));
                    $runtimeStart = $runtimeStart[2] . '.' . $runtimeStart[1] . '.' . $runtimeStart[0];

                    $licenses = new Licenses();
                    $maxLicense = Licenses::max('id');

                    if ($maxLicense > 0)
                        $licenseId = (int) $maxLicense + 1;
                    else
                        $licenseId = 1;

                    $licenses -> id = $licenseId;
                    $licenses -> name = $request -> input('name');
                    $licenses -> description = $request -> input('description');
                    $licenses -> price = (int) $request -> input('price');
                    $licenses -> renovation_month = (int) $request -> input('renovation_month');
                    $licenses -> provider = (int) $request -> input('provider');
                    $licenses -> client = (int) $request -> input('client');
                    $licenses -> payment = (int) $request -> input('payment');
                    $licenses -> runtime_start = $runtimeStart;
                    $licenses -> save();
                }

                else if ($request -> input('type') == 'provider') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'link' => 'required'
                    ]);

                    $providers = new Providers();
                    $maxProvider = Providers::max('id');

                    if ($maxProvider)
                        $providerId = (int) $maxProvider + 1;
                    else
                        $providerId = 1;

                    $providers -> id = $providerId;
                    $providers -> name = $request -> input('name');
                    $providers -> description = $request -> input('description');
                    $providers -> link = $request -> input('link');
                    $providers -> save();
                }

                else if ($request -> input('type') == 'client') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'link' => 'required'
                    ]);

                    $clients = new Clients();
                    $maxClient = Clients::max('id');

                    if ($maxClient >= 0)
                        $clientId = (int) $maxClient + 1;
                    else
                        $clientId = 1;

                    $clients -> id = $clientId;
                    $clients -> name = $request -> input('name');
                    $clients -> description = $request -> input('description');
                    $clients -> link = $request -> input('link');
                    $clients -> save();
                }

                else if ($request -> input('type') == 'payment') {
                    $request -> validate(['name' => 'required']);

                    $payments = new Payments();
                    $maxPayment = Payments::max('id');

                    if ($maxPayment >= 0)
                        $paymentId = (int) $maxPayment + 1;
                    else
                        $paymentId = 1;

                    $payments -> id = $paymentId;
                    $payments -> name = $request -> input('name');
                    $payments -> save();
                }
            }

            return redirect('/');
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }
    public function edit($type, $id) {
        if (Session::get('password') == $this -> password) {
            return view('main', [
                'licenses' => Licenses::get(['id', 'name']), 'type' => $type, 'id' => $id,
                'providers' => Providers::all(), 'clients' => Clients::all(), 'payments' => Payments::all()
            ]);
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }

    public function editSend(Request $request, $type, $id) {
        if (Session::get('password') == $this -> password) {
            if ($request -> input('_token') && $type == $request -> input('type') && $id == $request -> input('id')) {
                if ($request -> input('type') == 'license') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'price' => 'required|decimal:2',
                        'renovation_month' => 'required|integer|min:0',
                        'provider' => 'required|integer|min:1',
                        'client' => 'required|integer|min:1',
                        'payment' => 'required|integer|min:1',
                        'runtime_start' => 'required'
                    ]);

                    $runtimeStart = explode('-', $request -> input('runtime_start'));
                    $runtimeStart = $runtimeStart[2] . '.' . $runtimeStart[1] . '.' . $runtimeStart[0];

                    Licenses::where('id', '=', (int) $request -> input('id')) -> update([
                        'name' => $request -> input('name'),
                        'description' => $request -> input('description'),
                        'price' => (double) $request -> input('price'),
                        'renovation_month' => (int) $request -> input('renovation_month'),
                        'provider' => (int) $request -> input('provider'),
                        'client' => (int) $request -> input('client'),
                        'payment' => (int) $request -> input('payment'),
                        'runtime_start' => $runtimeStart
                    ]);
                }

                else if ($request -> input('type') == 'provider') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'link' => 'required'
                    ]);

                    Providers::where('id', '=', (int) $request -> input('id')) -> update([
                        'name' => $request -> input('name'),
                        'description' => $request -> input('description'),
                        'link' => $request -> input('link')
                    ]);
                }

                else if ($request -> input('type') == 'client') {
                    $request -> validate([
                        'name' => 'required',
                        'description' => 'required',
                        'link' => 'required'
                    ]);

                    Clients::where('id', '=', (int) $request->input('id'))->update([
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                        'link' => $request -> input('link')
                    ]);
                }

                else if ($request -> input('type') == 'payment') {
                    $request -> validate(['name' => 'required']);

                    Payments::where('id', '=', (int) $request -> input('id')) -> update([
                        'name' => $request -> input('name')
                    ]);
                }
            }

            return redirect('/');
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }
    public function delete(Request $request, $type, $id) {
        if (Session::get('password') == $this -> password) {
            if ($request -> input('_token')) {
                if ($request -> input('type') == 'license' && $type == $request -> input('type') && $id == $request -> input('id'))
                    Licenses::where('id', '=', (int) $request -> input('id')) -> delete();

                else if ($request -> input('type') == 'provider' && $type == $request -> input('type') && $id == $request -> input('id')) {
                    Providers::where('id', '=', (int) $request -> input('id')) -> delete();
                    $license = Licenses::where('provider', '=', $request -> input('id'));
                    if ($license)
                        $license -> update(['provider' => 0]);
                }

                else if ($request -> input('type') == 'client' && $type == $request -> input('type') && $id == $request -> input('id')) {
                    Clients::where('id', '=', (int) $request -> input('id')) -> delete();
                    $license = Licenses::where('client', '=', $request -> input('id'));
                    if ($license)
                        $license -> update(['client' => 0]);
                }

                else if ($request -> input('type') == 'payment' && $type == $request -> input('type') && $id == $request -> input('id')) {
                    Payments::where('id', '=', (int) $request -> input('id')) -> delete();
                    $license = Licenses::where('payment', '=', $request -> input('id'));
                    if ($license)
                        $license -> update(['payment' => 0]);
                }
            }

            return redirect('/');
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }
}

?>
