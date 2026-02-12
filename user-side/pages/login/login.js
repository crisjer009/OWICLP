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
        
        // Show loading spinner inside button
        if(!$submitBtn.find('.spinner').length) {
            $submitBtn.prepend('<span class="spinner" style="width:18px;height:18px;border:3px solid #fff;border-top:3px solid transparent;border-radius:50%;display:inline-block;margin-right:10px;animation:spin 1s linear infinite;"></span>');
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
                var delay = Math.max(0, 3000 - elapsed); // Ensure total 3 seconds loading only

                setTimeout(function() {
                    $submitBtn.find('.spinner').remove(); // Remove spinner
                    $message.text(response.message);

                    if(response.status === 'success') {
                        window.location.href = '../dashboard.php';
                    } else {
                        if(response.lock) { // user account will be locked after the 3 wrong attempts 
                            $submitBtn.text('ACCOUNT LOCKED').prop('disabled', true);
                        } else {
                            $submitBtn.text('LOG IN').prop('disabled', false);
                        }
                    }
                }, delay);
            },
            error: function() {
                var elapsed = new Date().getTime() - startTime;
                var delay = Math.max(0, 3000 - elapsed);

                setTimeout(function() {
                    $submitBtn.find('.spinner').remove();
                    $message.text('An error occurred. Please try again.');
                    $submitBtn.text('LOG IN').prop('disabled', false);
                }, delay);
            }
        });

    });
});
