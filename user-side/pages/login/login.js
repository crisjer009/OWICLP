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

        $submitBtn.text('Logging in...').prop('disabled', true);
        $message.text('');

        $.ajax({
            url: 'login_process.php', 
            type: 'POST',
            dataType: 'json',
            data: { username: username, password: password },
            success: function(response) {
                if(response.status === 'success') {
                    window.location.href = '../dashboard.php';
                } else {
                    $message.text(response.message);
                    $submitBtn.text('LOG IN').prop('disabled', false);
                }
            },
            error: function() {
                $message.text('An error occurred. Please try again.');
                $submitBtn.text('LOG IN').prop('disabled', false);
            }
        });
    });
});
