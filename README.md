# LAMP Demo

To Execute this application we would be using LAMP stack.
Deploy the application code in apache server
docker run -d --name bookdb -p 3306:3306 bookdb
docker run -d --name bookapp -p 8080:80 --link bookdb:mysql bookapp
