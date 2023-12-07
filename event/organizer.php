<?php
function getOrganizer() {
    $inject = ['title'=>'Login', 'body'=>''];
    
    
}

function getOrganizerForm($error = '') {
    return '<div>
        <form action="" method="post">
            <div> 
                <label for="login_email">Email address</label>
                <input type="email" id="login_email" name="login_email" aria-describedby="emailHelp" required>
            </div>
            <div> 
                <label for="login_password">Password</label>
                <input type="password" id="login_password" name="login_password" required>
            </div>
            <button type="submit">Submit</button>
        </form>
        <div><p>'. $error .'</p></div>
    </div>';
}
?>