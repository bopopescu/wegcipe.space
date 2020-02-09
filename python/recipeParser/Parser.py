#!/usr/bin/env python

from bs4 import BeautifulSoup
import urllib.request
from FoodParser import FoodParser
import sys

import fuzzywuzzy as fuzzywuzzy
from fuzzywuzzy import process
from fuzzywuzzy import fuzz
import mysql.connector as mysql

# connecting to the database using 'connect()' method
# it takes 3 required parameters 'host', 'user', 'passwd'
db = mysql.connect(
    host="localhost",
    user="root",
    passwd="3476269507",
    database="wegmansdb",
    auth_plugin='mysql_native_password'
)
#
# # creating an instance of 'cursor' class which is used to execute the 'SQL' statements in 'Python'

class Parser:
    def __init__(self, url):
        self.urlData = url

    urlData=""
    parsedIngredients = []
    names = []

    def ingredientParser(self):
        # open the url
        webUrl = urllib.request.urlopen(self.urlData)
        data = webUrl.read().decode("utf-8")
        # create beautiful soup object soup for each webpage
        soup = BeautifulSoup(data, "html.parser")
        #ingredients = soup.body.find("section", class_=r"recipe-ingredients").get_text("\n")
        ingredients = soup.body.find("section", class_=r"recipe-ingredients")
        if ingredients is None:
            ingredients = soup.body.find("section", class_=r"o-Ingredients")
        ingredients = ingredients.get_text("\n")
        listofingredients = ingredients.splitlines()
        fP = FoodParser()

        for line in listofingredients:
            if (not line == "") and line[0].isdigit() and len(line) > 4:
                entry = fP.parse(line)
                self.parsedIngredients.append(entry)
                self.names.append(entry["name"])

#p = Parser("https://www.foodnetwork.com/recipes/ina-garten/16-bean-pasta-e-fagioli-3612570/")
#p = Parser("https://www.allrecipes.com/recipe/86230/szechwan-shrimp/")
p = Parser(sys.argv[1])
#p = Parser("https://www.delish.com/cooking/recipe-ideas/a27211333/instant-pot-chicken-breasts-recipe/")
p.ingredientParser()
print(p.parsedIngredients)
print(p.names)

file = open("file.txt", "r")
#print(file.read())
#
# for line in file:
#     choices=

choices = [line.rstrip('\n') for line in file]
#print(choices[0])
userInput = p.names

#print(process.extract(userInput, choices))
count = 0
for item in userInput:
    suggestion = process.extractOne(item, choices)
    newName = suggestion[0]
    p.parsedIngredients[count]['name'] = newName
    count +=1
print(p.parsedIngredients)

for item in p.parsedIngredients:
    cursor = db.cursor()
    query = "INSERT INTO selections SELECT * FROM products WHERE product LIKE '%s'" % item["name"]
    cursor.execute(query)
    db.commit()