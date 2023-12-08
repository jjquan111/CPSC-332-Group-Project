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


CREATE VIEW EventDetailView AS
SELECT
    E.eventID,
    E.eventName,
    E.published,
    E.description,
    E.startTime,
    E.endTime,
    E.capacity,
    E.eventType,
    E.time_stamp,
    U.uniName,
    V.venueName,
    V.address,
    KS.speakerName,
    S.sponsorName,
    O.Fname,
    O.Lname
FROM _event AS E
    INNER JOIN university AS U ON E.uniID = U.uniID
    INNER JOIN venue AS V ON E.venID = V.venID
    INNER JOIN keynote_speaker AS KS ON E.speakerID = KS.speakerID
    INNER JOIN sponsor AS S ON E.sponsorID = S.sponsorID
    INNER JOIN user AS O ON E.organizerID = O.userID
ORDER BY E.eventID DESC;