--
-- Creating a sample table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Tags;
CREATE TABLE Tags (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "tags" TEXT NOT NULL,
    "threadId" TEXT NOT NULL
);
