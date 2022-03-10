DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS ranking;
DROP TABLE IF EXISTS matches;
DROP TABLE IF EXISTS teams;



CREATE TABLE teams(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE matches(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    team0 INTEGER(5) NOT NULL REFERENCES teams(id),
    team1 INTEGER(5) NOT NULL REFERENCES teams(id),
    score0 INTEGER(3) NOT NULL,
    score1 INTEGER(3) NOT NULL,
    m_date DATETIME NOT NULL,
    CHECK(team0 != team1),
    UNIQUE(team0, team1)
);

CREATE TABLE ranking(
    rank INTEGER(3) NOT NULL UNIQUE,
    team_id INTEGER PRIMARY KEY AUTOINCREMENT,
    match_played_count INTEGER(5) NOT NULL,
    match_won_count INTEGER(5) NOT NULL,
    match_lost_count INTEGER(5) NOT NULL,
    draw_count INTEGER(5) NOT NULL,
    goal_for_count INTEGER(5) NOT NULL,
    goal_against_count INTEGER(5) NOT NULL,
    goal_difference INTEGER(5) NOT NULL,
    points INTEGER(5) NOT NULL,
    FOREIGN KEY(team_id) REFERENCES teams(id)
);

CREATE TABLE users(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(128) UNIQUE NOT NULL,
    password_hash VARCHAR(128) NOT NULL
);