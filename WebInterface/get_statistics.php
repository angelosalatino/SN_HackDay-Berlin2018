<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function connect($pdo = false) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "snhackday";
    if ($pdo) {
        $dbh = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
        //$dbh = new PDO("mysql:host=localhost;dbname=cso", "cso", "pass");
        return($dbh);
    } else {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $conn->set_charset("utf8");
        $conn->set_charset("utf8");
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Connected successfully";
        return($conn);
    }
}

function disconnect($conn) {
    $conn->close();
}

function get_info($topic) {

    $return["topic"] = $topic;
    $metrics = get_metrics($topic);
    $return["metrics"] = $metrics;
    $entities = get_entities($topic);
    //print_r($entities);
    $return["entities"] = $entities;
    $subtopics = get_subtopics($topic);
    //print_r($subtopics);
    $return['subtopics'] = $subtopics;
    $discourse = get_discourse($topic);

    $return['discourse'] = $discourse;
    
    return $return;
}

function get_entities($topic) {
    #Journal 
    $query1 = 'SELECT topics2.topic, count(papers.id) as TEMP, papers.journal_name
FROM topics2
JOIN papers ON topics2.id=papers.id
JOIN journals2 ON papers.doi=journals2.doi
WHERE topics2.topic="' . $topic . '"
GROUP BY papers.journal_name
ORDER BY TEMP DESC';

#Organizations
    $query2 = 'SELECT organizations.organization, COUNT(papers.id) as TEMP, topics2.topic
FROM topics2 JOIN papers ON topics2.id=papers.id
JOIN organizations ON papers.id=organizations.id
WHERE topics2.topic="' . $topic . '"
GROUP BY organizations.organization
ORDER BY TEMP DESC';


#Authors (no number just the best)
    $query3 = 'SELECT authors.author, COUNT(papers.id) as TEMP, topics2.topic
FROM topics2 JOIN papers ON topics2.id=papers.id
JOIN authors ON papers.id=authors.id
WHERE topics2.topic="' . $topic . '"
GROUP BY authors.author
ORDER BY TEMP DESC';





    $conn = connect();
    /* bg<- broaderGeneric re<- relatedEquivalent st<- topic as subject ot<- topic as object */

    $result1 = $conn->query($query1);
    $result2 = $conn->query($query2);
    $result3 = $conn->query($query3);
    disconnect($conn);

    $rows1 = [];
    if ($result1->num_rows >= 1) {
        while ($row = $result1->fetch_assoc()) {
            $rows1[] = $row;
        }
    }
    $rows2 = [];
    if ($result2->num_rows >= 1) {
        while ($row = $result2->fetch_assoc()) {
            $rows2[] = $row;
        }
    }
    $rows3 = [];
    if ($result3->num_rows >= 1) {
        while ($row = $result3->fetch_assoc()) {
            $rows3[] = $row;
        }
    }

    $entities['journals'] = $rows1;
    $entities['organisations'] = $rows2;
    $entities['authors'] = $rows3;

    return $entities;
}

function get_metrics($topic) {
    $conn = connect();
    /* bg<- broaderGeneric re<- relatedEquivalent st<- topic as subject ot<- topic as object */
    $sql = "SELECT * FROM `topic_metrics` WHERE topic LIKE '" . $topic . "'";
    $result = $conn->query($sql);

    disconnect($conn);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        return $row;
    } else {
        return 0;
    }
}


function get_subtopics($topic){
    $conn = connect();
    /* bg<- broaderGeneric re<- relatedEquivalent st<- topic as subject ot<- topic as object */
    $sql = "SELECT name_subkeyword FROM `subtopics` WHERE name= '" . $topic . "' LIMIT 5";
    $result = $conn->query($sql);

    disconnect($conn);
    $rows = [];
    if ($result->num_rows >= 1) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row['name_subkeyword'];
        }
    }
    
    $info = [];
    foreach ($rows as $subtopic) {
        $temp = get_metrics($subtopic);
        if($temp){
           $list[]=$subtopic;
           $info[$subtopic] = $temp; 
        }
       
    }
    
    $result1['subtopics'] = $list;
    $result1['info'] = $info;
    
    return $result1;
}

function get_discourse($topic){
    $query1 = 'SELECT distinct SUBSTRING(role,5),count FROM `roles_per_topic` WHERE topic="'.$topic.'" and role != "DRI_Unspecified"';
        $conn = connect();
    /* bg<- broaderGeneric re<- relatedEquivalent st<- topic as subject ot<- topic as object */

    $result1 = $conn->query($query1);
    disconnect($conn);

    $rows1 = [];
    if ($result1->num_rows >= 1) {
        while ($row = $result1->fetch_assoc()) {
            $rows1[] = $row;
        }
    }
    return $rows1;
}
