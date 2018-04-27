# SN_HackDay-Berlin2018

This repository is an attempt to gather all the developed scripts and the gathered data during the Springer Nature HackDay in Berlin (26/27 April 2018) from the team working on Hot Topics.

## Team members
Jenny Cardenas-Osorio, Thomas Scheidsteger, Jochen Teufel, Anne Lauscher, Angelo Salatino, Francesco Osborne, Eva Volná, Aman Bhardwaj, Chris Bendall 

## DumbDatabaseFinal folder
It contains the dumps of all the tables created during the hackday.
Main tables:
* journals (doi -> downloads in 2015,16,17)
* books (isbn -> downloads in 2015,16,17)

Other tables are derived from the journal table. All these tables share the same id. 

## Scripts
This folder aims (because I still don't have all the files) to contain all the scripts that have been developed to download the information related to the papers: metadata, topics, metrics, and scientific discourse.

## Web Interface
This is a netbeans project, developed in PHP, which is the user interface of this proof of concept.

For a given topic, it explores the database in _DumpDatabaseFinal_ and retrieves all meaningful information related to it.
