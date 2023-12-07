<?php
function getEventDetails($eventid) {
    try {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM _event WHERE eventID = ?");
        $stmt->bind_param("i", $eventid);
        $stmt->execute();
        $result = $stmt->get_result();
        $jobpost = $result->fetch_assoc();
        if (isset($jobpost)) {
            return [NULL, $jobpost];
        }
        return ['Failed to find JobPost.', NULL];
    }
    catch (Exception $e) {
        return ['Failed to find JobPost. ' . $e, NULL];
    }
}
?>