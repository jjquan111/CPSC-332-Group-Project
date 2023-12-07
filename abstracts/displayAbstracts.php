<?php
require_once('../base.php');

function getAbstractsByTypeAndSubject($type, $subject) {
    global $conn;  // Ensure you have a database connection

    // Prepare the SQL query to fetch abstracts along with presenter and mentor information
    $stmt = $conn->prepare("SELECT a.title, a.abstractText, a.abstractType, a.subject, u.Fname as primaryPresenterFName, u.Lname as primaryPresenterLName, u.email as primaryPresenterEmail, u.institution as primaryPresenterInstitution, m.fullName as mentorFullName, m.email as mentorEmail, m.institution as mentorInstitution FROM abstract a JOIN user u ON a.presenterID = u.userID JOIN mentor m ON a.mentorID = m.userID WHERE a.abstractType = ? AND a.subject = ?");
    $stmt->bind_param("ss", $type, $subject);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

if (isset($_GET['type']) && isset($_GET['subject'])) {
    $type = $_GET['type'];
    $subject = $_GET['subject'];

    // Fetch abstracts
    $abstracts = getAbstractsByTypeAndSubject($type, $subject);

    $inject = [
        'title' => 'Abstracts: ' . $type . ' - ' . $subject,
        'body' => '<div class="container"><h2>Abstracts for ' . htmlspecialchars($type) . ' in ' . htmlspecialchars($subject) . '</h2><ul>'
    ];

    foreach ($abstracts as $abstract) {
        // Note: This is a basic implementation. You might need to adjust it based on your actual database structure.
        $inject['body'] .= "<li>
            <strong>Title:</strong> " . htmlspecialchars($abstract['title']) . "<br>
            <strong>Abstract:</strong> " . htmlspecialchars($abstract['abstractText']) . "<br>
            <strong>Abstract Type:</strong> " . htmlspecialchars($abstract['abstractType']) . "<br>
            <strong>Subject Area:</strong> " . htmlspecialchars($abstract['subject']) . "<br>
            <strong>Primary Presenter:</strong> " . htmlspecialchars($abstract['primaryPresenterFName']) . " " . htmlspecialchars($abstract['primaryPresenterLName']) . ", " . htmlspecialchars($abstract['primaryPresenterEmail']) . ", " . htmlspecialchars($abstract['primaryPresenterInstitution']) . "<br>
            <strong>Faculty Mentor:</strong> " . htmlspecialchars($abstract['mentorFullName']) . ", " . htmlspecialchars($abstract['mentorEmail']) . ", " . htmlspecialchars($abstract['mentorInstitution']) . "</li><br>";
    }

    $inject['body'] .= '</ul></div>';
} else {
    $inject = [
        'title' => 'Abstracts Error',
        'body' => '<div class="container"><h2>Error: Missing Type or Subject</h2><p>Please select an abstract type and subject area.</p></div>'
    ];
}

printMain($inject);
?>
