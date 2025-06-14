<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use App\Models\Licenses;
use App\Models\Clients;
use App\Models\Payments;
use App\Models\Providers;

class LicenseController extends Controller {
    private $password = '641e65e9a91922db544fd9d171460e38';

    public function license($id) {
        if ($id == 'add') {
            if (Session::get('password') == $this -> password) {
                return view('add-license', [
                    'license' => ['name' => '', 'description' => '', 'price' => '', 'renovation_month' => '', 'runtime_start' => ''], 'type' => 'add', 'id' => '',
                    'provider_' => ['id' => '', 'name' => ''], 'client_' => ['id' => '', 'name' => ''], 'payment_' => ['id' => '', 'name' => ''],
                    'providers' => Providers::get(['id', 'name']), 'clients' => Clients::get(['id', 'name']), 'payments' => Payments::get(['id', 'name'])
                ]);
            }

            else {
                Session::put('url', url()->current());
                return redirect()->route('password');
            }
        }

        else {
            $license = Licenses::where('id', '=', (int) $id) -> first();

            if ($license) {
                $provider = Providers::where('id', '=', (int) $license['provider']) -> first();
                $client = Clients::where('id', '=', (int) $license['client']) -> first();
                $payment = Payments::where('id', '=', (int) $license['payment']) -> first();

                if ($provider)
                    $providerName = $provider['name'];
                else
                    $providerName = '';
                if ($client)
                    $clientName = $client['name'];
                else
                    $clientName = '';
                if ($payment)
                    $paymentName = $payment['name'];
                else
                    $paymentName = '';

                if ($license['renovation_month'] == 0)
                    $renovation = 'einmalig';

                else {
                    if ($license['renovation_month'] == 1)
                        $renovation = 'monthly';
                    else if ($license['renovation_month'] == 3)
                        $renovation = 'quarterly';
                    else if ($license['renovation_month'] == 6)
                        $renovation = 'half-yearly';
                    else if ($license['renovation_month'] == 12)
                        $renovation = 'yearly';
                    else
                        $renovation = 'after ' . $license['renovation_month'] . ' months';

                    $runtimeStartArray = explode('.', $license['runtime_start']);
                    $runtimeStart = (int) $runtimeStartArray[1] + (int) $runtimeStartArray[2] * 12;
                    $today = (int) date('m') + (int) date('Y') * 12;
                    $runtimeEnd = $runtimeStart + $today + $license['renovation_month'] - $runtimeStart - ceil(($today - $runtimeStart) % $license['renovation_month']) - 1;
                    $runtimeEnd = (string) $runtimeStartArray[0] . '.' . (string) $runtimeEnd % 12 + 1 . '.' . (string) floor($runtimeEnd / 12);
                }

                return view('license', [
                    'license' => $license, 'renovation' => $renovation, 'runtimeEnd' => $runtimeEnd,
                    'provider' => $providerName, 'client' => $clientName, 'payment' => $paymentName, 'id' => $id,
                ]);
            }

            else
                return '<body style="margin: 0; background-color: #1a1a1a;"></body>';
        }
    }

    public function licenseEdit(int $id) {
        if (Session::get('password') == $this -> password) {
            $license = Licenses::where('id', '=', (int) $id) -> first();

            if ($license) {
                $provider = Providers::where('id', '=', (int) $license['provider']) -> first();
                $client = Clients::where('id', '=', (int) $license['client']) -> first();
                $payment = Payments::where('id', '=', (int) $license['payment']) -> first();

                if (!$provider) {$provider = ['id' => '', 'name' => ''];}
                if (!$client) {$client = ['id' => '', 'name' => ''];}
                if (!$payment) {$payment = ['id' => '', 'name' => ''];}

                $runtimeStart = explode('.', $license['runtime_start']);
                $license['runtime_start'] = $runtimeStart[2] . '-' . $runtimeStart[1] . '-' . $runtimeStart[0];

                return view('add-license', [
                    'license' => $license,  'id' => $id, 'type' => 'edit', 'provider_' => $provider,
                    'client_' => $client, 'payment_' => $payment, 'providers' => Providers::get(['id', 'name']),
                    'clients' => Clients::get(['id', 'name']), 'payments' => Payments::get(['id', 'name'])
                ]);
            }

            else
                return '<body style="margin: 0; background-color: #1a1a1a;"></body>';
        }

        else {
            Session::put('url', url()->current());
            return redirect()->route('password');
        }
    }
}

?>
