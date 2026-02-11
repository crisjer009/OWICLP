$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        var username = $('input[name="username"]').val().trim();
        var password = $('input[name="password"]').val().trim();
        var $submitBtn = $('button[type="submit"]');
        var $message = $('#message');

        if(username === '' || password === '') {
            $message.text('Please enter both username and password.');
            return false;
        }



// loading button... /* need 3 sec loading only 
        $submitBtn.text('Logging in...').prop('disabled', true);
        $message.text('');

        $.ajax({
            url: 'login_process.php', 
            type: 'POST',
            dataType: 'json',
            data: { username: username, password: password },
            success: function(response) {
                $message.text(response.message);

                if(response.status === 'success') {
                    window.location.href = '../dashboard.php';
                } else {
                    // Disable button code if account is locked after 3 attempts
                    if(response.lock) {
                        $submitBtn.text('ACCOUNT LOCKED').prop('disabled', true);
                    } else {
                        $submitBtn.text('LOG IN').prop('disabled', false);
                    }
                }
            },
            error: function() {
                $message.text('An error occurred. Please try again.');
                $submitBtn.text('LOG IN').prop('disabled', false);
            }
        });
    });
});
