<?php
require_once('../base.php'); // Adjust the path as necessary

$conn = new mysqli($servername, $username, $password, $database);

// Check for a database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get abstracts by subject
function getAbstractsBySubject($subject) {
    global $conn;

    // Prepare the SQL statement to join abstracts with user details of the presenter
    $stmt = $conn->prepare("SELECT a.abstractID, a.accepted, a.deadline, a.abstractType, a.subject, 
                                   u.Fname AS presenterFirstName, u.Lname AS presenterLastName, u.email AS presenterEmail, u.institution AS presenterInstitution
                            FROM abstract a
                            JOIN user u ON a.presenterID = u.userID
                            WHERE a.subject = ?");
    
    // Bind the parameter and execute the statement
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any abstracts were found and return them
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // No matching abstracts found
    }
}

// Initialize an empty array to hold abstract details
$abstractDetails = [];

// Check if the 'subject' GET parameter is set
if (isset($_GET['subject'])) {
    // Fetch the abstracts based on the subject
    $subject = $_GET['subject'];
    $abstractDetails = getAbstractsBySubject($subject);
}

// Prepare the HTML to inject
$inject = [
    'title' => 'Abstract Details by Subject',
    'body' => '<div class="container"><h2>Abstract Details</h2>'
];

// If abstract details are available, loop through and display them
if (!empty($abstractDetails)) {
    foreach ($abstractDetails as $abstract) {
        $inject['body'] .= "<div><strong>Abstract ID:</strong> " . htmlspecialchars($abstract['abstractID']) . "</div>
                            <div><strong>Accepted:</strong> " . htmlspecialchars($abstract['accepted']) . "</div>
                            <div><strong>Deadline:</strong> " . htmlspecialchars($abstract['deadline']) . "</div>
                            <div><strong>Abstract Type:</strong> " . htmlspecialchars($abstract['abstractType']) . "</div>
                            <div><strong>Subject:</strong> " . htmlspecialchars($abstract['subject']) . "</div>
                            <div><strong>Presenter:</strong> " . htmlspecialchars($abstract['presenterFirstName']) . " " . htmlspecialchars($abstract['presenterLastName']) . "</div>
                            <div><strong>Email:</strong> " . htmlspecialchars($abstract['presenterEmail']) . "</div>
                            <div><strong>Institution:</strong> " . htmlspecialchars($abstract['presenterInstitution']) . "</div>";
    }
} else {
    // If no details were found, display a message
    $inject['body'] .= '<p>No details found for the selected subject.</p>';
}

// Close the container div and append to the body
$inject['body'] .= '</div>';

// Call a function to output the HTML content
printMain($inject);

// Close the database connection
$conn->close();
?>
