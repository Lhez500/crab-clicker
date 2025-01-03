/* SELECT users.user_id, users.username FROM users INNER JOIN counters ON  users.user_id=counters.user_id;
SELECT user_id FROM counters ORDER BY crabs desc limit 10;
 */
/* SELECT user_id , crabs FROM counters ORDER BY crabs desc limit 10 

SELECT username FROM users WHERE username UNION where user_id = user_id  */

SELECT u.username , c.crabs FROM (
     SELECT user_id , crabs
        FROM counters
        ORDER BY crabs DESC
        LIMIT 10
        ) AS c 
        JOIN users u ON c.user_id = u.user_id;
