--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Answers;
CREATE TABLE Answers (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "questionID" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "points" INTEGER,
    "text" TEXT NOT NULL
);
