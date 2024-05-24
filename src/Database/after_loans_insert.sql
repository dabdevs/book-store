DELIMITER $ $ CREATE TRIGGER after_loans_insert
AFTER
INSERT
    ON loans FOR EACH ROW BEGIN
UPDATE
    books
SET
    available = available - 1
WHERE
    id = NEW.book_id;

END $ $ DELIMITER;