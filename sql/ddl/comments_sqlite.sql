--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Comments;
CREATE TABLE Comments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "author" TEXT NOT NULL,
    "comment" TEXT NOT NULL,
    "threadId" TEXT NOT NULL,
    "points" INTEGER,
    "answerId" TEXT NOT NULL
);
