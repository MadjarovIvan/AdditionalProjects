<?php 
// create_tables();

function query(string $query, array $data = []){
    $string = "mysql:hostname=". DBHOST .";dbname=". DBNAME;
    $con = new PDO ($string, DBUSER, DBPASS);

    $query = "SELECT * FROM users WHERE id = :id ";
    $stm = $con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (is_array($result) && !empty($result)) {
        return $result;
    }
    return false;
}   

function create_tables(){
    $string = "mysql:host=". DBHOST .";";
    $con =  new PDO($string, DBUSER, DBPASS);
    //DATABASE
    $query = "CREATE database if not exists " . DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();
    
    $query = "use ". DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();
    
    //USERS TABLE
    $query = "CREATE table if not exists users(

        id int primary key auto_increment,

        username varchar(50) not null,
        email varchar(100) not null,
        password varchar(255) not null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        role varchar(10) not null,

        key email (email),
        key username (username)

    )";
    $stm = $con->prepare($query);
    $stm->execute();
    
    //CATEGORIES TABLE
    $query = "CREATE table if not exists categories(

        id int primary key auto_increment,

        category varchar(50) not null,
        slug varchar(100) not null,
        disabled tinyint(1) default 0,
        
        key slug (slug),
        key category (category)

    )";
    $stm = $con->prepare($query);
    $stm->execute();
    
    //POSTS TABLE
    $query = "CREATE table if not exists posts(

        id int primary key auto_increment,
        user_id int,
        category_id int,

        title varchar(100) not null,
        content text null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        slug varchar(100) not null,

        key user_id (user_id),
        key category_id (category_id),
        key title (title),
        key slug (slug),
        key date (date)

    )";
    $stm = $con->prepare($query);
    $stm->execute();
    
    print_r($con);
}