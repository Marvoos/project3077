-- SQL script to insert sample book data into the books table
INSERT INTO books (name, author, description, copies_available) VALUES
-- Fiction
('The Silent Forest', 'Lena Hart', 'A mystery unfolds in a remote woodland town.', 3),
('Crimson Skies', 'Derek Vale', 'A war pilot uncovers a hidden conspiracy.', 0),
('Echoes of Tomorrow', 'Nina Brooks', 'Time travel comes with unintended consequences.', 2),
('The Glass City', 'Arman Cole', 'A futuristic city built entirely of glass.', 1),

-- Fantasy
('Realm of Ashes', 'T.K. Rowan', 'A fallen kingdom seeks redemption through fire.', 0),
('The Dragon’s Pact', 'Elise Winter', 'A young warrior bonds with a forbidden dragon.', 4),
('Moonlight Sorcery', 'Vera Nyx', 'Magic resurfaces under a blood moon.', 2),

-- Sci-Fi
('Orbit Zero', 'Caleb Stroud', 'Astronauts face a crisis beyond Earth’s orbit.', 0),
('Neon Horizon', 'Jax Mercer', 'A cyberpunk tale of rebellion and AI.', 5),
('Binary Souls', 'Iris Chen', 'Humans and machines blur the line of identity.', 1),

-- Romance
('Letters to June', 'Maya Ellis', 'A love story told through lost letters.', 3),
('Falling for Autumn', 'Grace Miller', 'A seasonal romance in a small town.', 0),

-- Thriller
('The Last Witness', 'Owen Pierce', 'A key witness disappears before trial.', 2),
('Dark Signal', 'Riley Knox', 'A hacker uncovers a dangerous secret.', 0),

-- Non-fiction
('Mind Over Matter', 'Dr. Samuel Reed', 'Exploring the power of human focus.', 6),
('History of Tomorrow', 'Alina Graves', 'Predictions based on past global trends.', 2),

-- Misc / Variety
('Cooking with Fire', 'Marco Diaz', 'Bold recipes using open flame techniques.', 3),
('The Art of Stillness', 'Lila Moore', 'Finding peace in a chaotic world.', 1),
('Urban Legends Revisited', 'Tom Sawyer Jr.', 'Investigating modern myths.', 0),
('Beginner’s Guide to Coding', 'Alex Turner', 'An introduction to programming basics.', 7);