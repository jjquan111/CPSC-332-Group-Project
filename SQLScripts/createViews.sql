DROP VIEW IF EXISTS PostPreviewView;

USE cybermagicians;

CREATE VIEW EventView AS
SELECT
    E.eventID,
    E.eventName,
    E.description,
    E.startTime,
    E.endTime,
    E.capacity
FROM _event AS E;