<?php
require_once('../base.php');

// Function to get an abstract by its ID
function getAbstractById($abstractID) {
    global $conn;  // Assuming $conn is your global database connection variable

    // Check if $conn is not null
    if ($conn === null) {
        throw new Exception("Database connection not established.");
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT a.title, a.abstractText, a.abstractType, a.subject, u.Fname, u.Lname, u.email, u.institution, m.fullName as mentorFullName, m.email as mentorEmail, m.institution as mentorInstitution FROM abstract a JOIN user u ON a.presenterID = u.userID LEFT JOIN mentor m ON a.mentorID = m.userID WHERE a.abstractID = ?");

    // Bind the abstractID to the query
    $stmt->bind_param("i", $abstractID);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Return the fetched data
    return $result->fetch_assoc();
}

// Example usage
$abstractDetails = [];
if (isset($_GET['abstractID'])) {
    $abstractID = $_GET['abstractID'];  // Get the abstract ID from the URL parameter

    // Fetch the abstract details
    $abstractDetails = getAbstractById($abstractID);
}

$inject = [
    'title' => 'Abstract Details',
    'body' => '<div class="container"><h2>Abstract Details</h2>'
];

// Display the abstract details
if ($abstractDetails) {
    $inject['body'] .= "<p><strong>Title:</strong> {$abstractDetails['title']}</p>
                        <p><strong>Abstract:</strong> {$abstractDetails['abstractText']}</p>
                        <p><strong>Type:</strong> {$abstractDetails['abstractType']}</p>
                        <p><strong>Subject:</strong> {$abstractDetails['subject']}</p>
                        <p><strong>Presenter:</strong> {$abstractDetails['Fname']} {$abstractDetails['Lname']}</p>
                        <p><strong>Email:</strong> {$abstractDetails['email']}</p>
                        <p><strong>Institution:</strong> {$abstractDetails['institution']}</p>
                        <p><strong>Mentor:</strong> {$abstractDetails['mentorFullName']}</p>
                        <p><strong>Mentor Email:</strong> {$abstractDetails['mentorEmail']}</p>
                        <p><strong>Mentor Institution:</strong> {$abstractDetails['mentorInstitution']}</p>";
} else {
    $inject['body'] .= '<p>No details found for the selected abstract.</p>';
}

$inject['body'] .= '</div>';

printMain($inject);
?>
