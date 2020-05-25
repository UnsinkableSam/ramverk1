--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Questions;
CREATE TABLE Questions (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "title" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "tags" TEXT NOT NULL,
    "points" INTEGER,
    "text" TEXT NOT NULL
);
