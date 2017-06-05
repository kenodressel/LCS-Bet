LCS-Bet
=======

This is an open source betting system. There is currently no "value" of games. You can simply bet on the team, you expect to win. Its designed to be used by a group of people who know each other and not try to abuse the system since there are probably many bugs in there.

### Please note: 
- I really appreciate every addition to my code
- this is nowhere a complete version
- the current data is only for the EU LCS week 3+ (NA is planned)

## Installation and setup

### Here are the things you need:
- Webserver with MySQL and PHP (you can also use your pc: [XAMPP](www.apachefriends.org))
- Basic knowledge in MySQL (you can get it work by googling)
- ~30 mins of your precious time

### The installation steps are:

1. Download ("Download ZIP") or clone the repository
2. If you dont have your webserver going, google now, how to do it
3. Enter your MySQL details in connect.php
4. Upload all files from the ZIP to your webserver
5. Import the files from Database_structure in your database (first structure.sql, then data.sql)
6. Now you need to add the allowed users to the usertable. (registration is not implemented and not wanted for a round of friends)
7. The user with the id = 1 should be an admin account, it will be used to enter wins
8. Add all others users and their passwords hashed with md5
9. Done.
