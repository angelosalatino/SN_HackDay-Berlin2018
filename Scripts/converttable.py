#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Apr 27 10:37:11 2018

@author: angelosalatino
"""


import json
import mysql.connector



cnx = mysql.connector.connect(user='root', password='',
                              host='127.0.0.1',
                              database='snhackday')
cursor = cnx.cursor()

query = ("SELECT * FROM `topics`")

cursor.execute(query)

papers=[]
for elem in cursor:
    papers.append(elem)

cursor.close()  
cnx.close()

cnx = mysql.connector.connect(user='root', password='',
                              host='127.0.0.1',
                              database='snhackday')

cursor = cnx.cursor()

i=0
for paper in papers:
    if(len(paper[1])>3):
        i=i+1
        print(str(i)+" "+paper[1][-4:])
        
        id_p = paper[0]
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
        
            
    
        
        for topic in topics:
        
            add_topics = ("INSERT INTO topics2 "
                       "(id,topic,flag_kind) "
                       "VALUES (%s, %s, %s)")
        
            data_topics = (id_p,topic,0)
        
            # Insert new employee
            cursor.execute(add_topics, data_topics)

cnx.close()