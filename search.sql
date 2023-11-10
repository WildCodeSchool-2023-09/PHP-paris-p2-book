SELECT
-- DATA TO DISPLAY :
    be.id, b.title, be.cover, be.synopsis, a.firstname, a.lastname, e.label

    -- be.id as book_editor_id, be.nb_pages as nb_pages,
    -- b.title as book_title,
    -- a.firstname as author_firstname, a.lastname as author_lastname,
    -- g.label as genres,
    -- e.label as editor,
    -- -- reviews nb & avg note,
    -- COUNT(r.id) as nb_reviews, AVG(r.note) as avg_note,
    -- t.label as tags
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
    JOIN review as r
        ON be.id = r.book_editor_id
    -- tag.label
    JOIN review_tag as rt
        ON r.id = rt.review_id
    JOIN tag as t
        ON rt.tag_id = t.id
-- GROUP BY book_editor_id
;