<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class PasswordController {
    private $password = '641e65e9a91922db544fd9d171460e38';

    public function password() {
        echo "<script>
            var password = prompt('This is a protected page. Please enter the password:')
            window.location.href = '/password/' + password
        </script>";
    }

    public function passwordCheck($password) {
        if (isset($password)) {
            if (md5(md5($password)) == $this -> password) {
                Session::put('password', md5(md5($password)));
                echo "<script>
                    alert('The password is correct. You will be now redirected.')
                    var url = '" . Session::get('url') . "'
                    if (url)
                        window.location.href = url
                    else
                        window.location.href = '/'
                </script>";
            }

            else {
                echo "<script>
                    alert('The password is incorrect.')
                    window.location.href = '/password'
                </script>";
            }
        }
    }
}
