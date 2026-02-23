$(document).ready(function() {

    var $username = $('input[name="username"]');
    var $password = $('input[name="password"]');
    var $submitBtn = $('#loginBtn');
    var $message = $('#message');

    // Disable button on load
    $submitBtn.prop('disabled', true);

    function checkInputs() {

        var usernameVal = $username.val().trim();
        var passwordVal = $password.val().trim();

        if(usernameVal === '' && passwordVal === '') {

            $message.text('Please input username and password.')
                    .css('color','red');

            $submitBtn.prop('disabled', true);

        }
        else if(usernameVal === '') {

            $message.text('Please input username.')
                    .css('color','red');

            $submitBtn.prop('disabled', true);

        }
        else if(passwordVal === '') {

            $message.text('Please input password.')
                    .css('color','red');

            $submitBtn.prop('disabled', true);

        }
        else {

            $message.text('');
            $submitBtn.prop('disabled', false);

        }

    }

    $username.on('input', checkInputs);
    $password.on('input', checkInputs);


    $('#loginForm').on('submit', function(e) {

        e.preventDefault();

        var username = $username.val().trim();
        var password = $password.val().trim();

        if(username === '' || password === '') {

            $message.text('Please input username and password.')
                    .css('color','red');

            $submitBtn.prop('disabled', true);

            return false;
        }

        // for spinner
        if(!$submitBtn.find('.spinner').length) {

            $submitBtn.prepend(
                '<span class="spinner" style="width:18px;height:18px;border:3px solid #fff;border-top:3px solid transparent;border-radius:50%;display:inline-block;margin-right:10px;animation:spin 1s linear infinite;"></span>'
            );

        }

        $submitBtn.prop('disabled', true);
        $message.text('');

        var startTime = new Date().getTime();

        $.ajax({

            url: 'login_process.php',
            type: 'POST',
            dataType: 'json',
            data: { username: username, password: password },

            success: function(response) {

                var elapsed = new Date().getTime() - startTime;
                var delay = Math.max(0, 3000 - elapsed);

                setTimeout(function() {

                    $submitBtn.find('.spinner').remove();

                    if(response.status === 'success') {

                        $message.text(response.message)
                                .css('color','green');

                        window.location.href = '../dashboard.php';
                    }
                    else {

                        $message.text(response.message)
                                .css('color','red');

                        if(response.lock) {

                            $submitBtn.text('ACCOUNT LOCKED')
                                      .prop('disabled', true);

                        }
                        else {

                            $submitBtn.text('LOG IN');
                            checkInputs();

                        }

                    }

                }, delay);

            },

            error: function() {

                var elapsed = new Date().getTime() - startTime;
                var delay = Math.max(0, 3000 - elapsed);

                setTimeout(function() {

                    $submitBtn.find('.spinner').remove();

                    $message.text('An error occurred. Please try again.')
                            .css('color','red');

                    $submitBtn.text('LOG IN');

                    checkInputs();

                }, delay);

            }

        });

    });

});
