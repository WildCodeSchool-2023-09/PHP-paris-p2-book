SELECT
-- DATA TO DISPLAY :
    be.id as id, b.title as title, CONCAT(a.firstname, ' ', a.lastname) as author, be.cover as cover, e.label as editor, b.written_at as date, g.label as genre
    -- ,COUNT(r.id) as nb_reviews
    -- ,AVG(r.note) as avg_note

-- book_editor.nb_pages
FROM book_editor as be
    -- book.title :
    JOIN book as b
        ON be.id = b.id
    -- author.firstname & .lastname
    JOIN book_author as ba
        ON b.id = ba.book_id
    JOIN author as a
        ON ba.author_id = a.id
    -- genre.label
    JOIN book_genre as bg
        ON b.id = bg.book_id
    JOIN genre as g
        ON bg.genre_id = g.id
    -- editor.label
    JOIN editor as e
        ON be.editor_id = e.id
    -- reviews nb & average note
    LEFT JOIN review as r
        ON be.id = r.book_editor_id
    LEFT JOIN user
        ON r.user_id = user.id
-- GROUP BY t.id
