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

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT abstractID, accepted, deadline, abstractType, subject, presenterID, eventID
                            FROM abstract
                            WHERE subject = ?");

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
        $inject['body'] .= "<p><strong>Abstract ID:</strong> " . htmlspecialchars($abstract['abstractID']) . "</p>
                            <p><strong>Accepted:</strong> " . htmlspecialchars($abstract['accepted']) . "</p>
                            <p><strong>Deadline:</strong> " . htmlspecialchars($abstract['deadline']) . "</p>
                            <p><strong>Abstract Type:</strong> " . htmlspecialchars($abstract['abstractType']) . "</p>
                            <p><strong>Subject:</strong> " . htmlspecialchars($abstract['subject']) . "</p>
                            <p><strong>Presenter ID:</strong> " . htmlspecialchars($abstract['presenterID']) . "</p>
                            <p><strong>Event ID:</strong> " . htmlspecialchars($abstract['eventID']) . "</p>";
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
