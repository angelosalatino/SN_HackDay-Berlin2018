#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Apr 27 12:23:56 2018

@author: angelosalatino
"""

import json
import mysql.connector


#download topics, doi, downloads

cnx = mysql.connector.connect(user='root', password='',
                              host='127.0.0.1',
                              database='snhackday')
cursor = cnx.cursor()
query = ("SELECT topics.id, topics.topic, papers.doi FROM `topics`  LEFT JOIN papers ON papers.id=topics.id")
cursor.execute(query)

papers=[]
for elem in cursor:
    papers.append(elem)
    
cnx.close()



downloads_2015 = {}
downloads_2016 = {}
downloads_2017 = {}

cnx = mysql.connector.connect(user='root', password='',
                              host='127.0.0.1',
                              database='snhackday')
cursor = cnx.cursor()

for paper in papers:
    if(len(paper[1])>3):
    
        if(paper[1].endswith('"]')):
            topics = paper[1]
            topics=json.loads(topics)
        elif(paper[1].endswith(' "')):
            topics = paper[1]+'"]'
            topics=json.loads(topics)
        elif(paper[1].endswith('"')):
            topics = paper[1]+']'
            topics=json.loads(topics)
        elif(paper[1].endswith(', ')):
            topics = paper[1]+'""]'
            topics=json.loads(topics)
            topics=topics[:-1]
        elif(paper[1].endswith(',')):
            topics = paper[1]+'""]'
            topics=json.loads(topics)
            topics=topics[:-1]
        else:
            topics = paper[1]+'"]'
            topics=json.loads(topics)
            topics=topics[:-1]
        
        
        query = ("SELECT `2015`,`2016`,`2017` FROM `journals` WHERE `﻿doi` LIKE '"+paper[2]+"'")
        cursor.execute(query)
        row = cursor.fetchone()
        dn_2015 = row[0]
        dn_2016 = row[1]
        dn_2017 = row[2]
        
        
        for topic in topics:
            if(topic in downloads_2015):
                downloads_2015[topic] = downloads_2015[topic]+dn_2015;
            else:
                downloads_2015[topic] = dn_2015;
                
            if(topic in downloads_2016):
                downloads_2016[topic] = downloads_2016[topic]+dn_2016;
            else:
                downloads_2016[topic] = dn_2016;
            
            if(topic in downloads_2017):
                downloads_2017[topic] = downloads_2017[topic]+dn_2017;
            else:
                downloads_2017[topic] = dn_2017;
            
cnx.close()


