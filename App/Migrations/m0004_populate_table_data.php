<?php

use App\Core\Application;

class m0004_populate_table_data
{
    public function up(): void
    {
        $db = Application::$app->db;

        // Table users
        $SQLUsers = <<<SQL
        INSERT INTO users (first_name, last_name, email, password, is_admin, created_at)
        VALUES
            ('John', 'Doe', 'john.doe@example.com', :password1, false, '2023-01-01 12:00:00'),
            ('Jane', 'Smith', 'jane.smith@example.com', :password2, true, '2023-01-02 14:30:00'),
            ('Bob', 'Johnson', 'bob.johnson@example.com', :password3, false, '2023-01-03 10:15:00');
SQL;

        $statementUsers = $db->pdo->prepare($SQLUsers);

        // Table posts
        $SQLPosts = <<<SQL
            INSERT INTO posts (author_id, title, body, description, image_name, approved_by, approved_at, created_at, updated_at)
            VALUES
                (1, 'Introduction to SQL', 'This is a post about SQL...', 'Learn the basics of SQL', NULL, 2, '2023-01-05 09:45:00', '2023-01-04 18:00:00', '2023-01-04 18:00:00'),
                (2, 'Web Development Tips', 'In this post, we share web development tips...', 'Useful tips for web developers', NULL, 3, '2023-01-06 11:30:00', '2023-01-05 14:20:00', '2023-01-05 14:20:00'),
                (3, 'Database Design', 'Learn how to design a database...', 'Essential concepts in database design', NULL, 1, '2023-01-07 15:20:00', '2023-01-06 22:10:00', '2023-01-06 22:10:00');
        SQL;

        $statementPosts = $db->pdo->prepare($SQLPosts);

        // Table comments
        $SQLComments = <<<SQL
        INSERT INTO comments (author_id, post_id, content, approved_by, approved_at, created_at, updated_at)
            VALUES
                (2, 1, 'Great introduction! Looking forward to more content.', 1, '2023-01-05 10:00:00', '2023-01-04 18:30:00', '2023-01-04 18:30:00'),
                (3, 1, 'Very informative. Thanks for sharing!', 2, '2023-01-05 11:15:00', '2023-01-04 19:00:00', '2023-01-04 19:00:00'),
                (1, 2, 'These tips are awesome. Keep them coming!', 3, '2023-01-06 12:00:00', '2023-01-05 14:45:00', '2023-01-05 14:45:00'),
                (2, 3, 'I have a question about database normalization...', NULL, NULL, '2023-01-07 16:00:00', '2023-01-06 22:45:00');
        SQL;

        $statementComments = $db->pdo->prepare($SQLComments);

        // Hashing passwords
        $password1 = password_hash('admin123', PASSWORD_BCRYPT);
        $password2 = password_hash('admin123', PASSWORD_BCRYPT);
        $password3 = password_hash('admin123', PASSWORD_BCRYPT);

        // Binding parameters for users table
        $statementUsers->bindParam(':password1', $password1, PDO::PARAM_STR);
        $statementUsers->bindParam(':password2', $password2, PDO::PARAM_STR);
        $statementUsers->bindParam(':password3', $password3, PDO::PARAM_STR);

        // Execute statements
        $statementUsers->execute();
        $statementPosts->execute();
        $statementComments->execute();
    }
}
