import http.client
import mimetypes
import json
import csv
import itertools
import mysql.connector as mysql
href_suf = "&Subscription-Key=9e69b037823d481989bfd9ace7e9b590"

conn = http.client.HTTPSConnection("api.wegmans.io")
payload = ''
headers = {

}
conn.request("GET", "/products/categories?api-version=2018-10-18&Subscription-Key=9e69b037823d481989bfd9ace7e9b590", payload, headers)
res = conn.getresponse()
data = res.read()

data_string = data.decode("utf-8")

categories_dict = json.loads(data_string)

categories_list = categories_dict['categories']

#categories_list1 = categories_list[1:2]
#categories_list2 = categories_list[4:]
#categories_list = categories_list1 + categories_list2

#print(len(categories_list))
#print(categories_list)
#res.close()

category_dict_list = []
products_dict_list = []
product_dict_list = []
products_list_product_item = []
product_info_dict_list = []

conn.close()
for i in range(len(categories_list)):
    categories_link_item = categories_list[i]
    categories_links_list = categories_link_item['_links']

    ##for j in range(len(categories_links_list)):
    categories_link_dict = categories_links_list[0]
    categories_link = categories_link_dict["href"]

    href_full = categories_link + href_suf

    conn.request("GET", href_full)
    res2 = conn.getresponse()
    data_category = res2.read()

    data_category_string = data_category.decode("utf-8")
    category_dict_each = json.loads(data_category_string)

    #category_dict.update(category_dict_each)
    category_dict_list.append(category_dict_each.copy())
    #res2.close()
    conn.close()

for i in range(len(category_dict_list)):
    category_dict_item = category_dict_list[i]
    category_link_list_item = category_dict_item["categories"]
    for j in range(len(category_link_list_item)):
        category_link_dict_item = category_link_list_item[j]

        products_categories_list = category_link_dict_item["_links"]
        products_links_dict = products_categories_list[0]
        products_link = products_links_dict["href"]

        products_href_full = products_link + href_suf

        #print(products_link)

        conn.request("GET", products_href_full)
        res3 = conn.getresponse()
        data_products = res3.read()
        data_products_string = data_products.decode("utf-8")

        products_dict_each = json.loads(data_products_string)
        #print(data_products_string)

        products_dict_list.append(products_dict_each.copy())
        #res3.close()
        conn.close()

for k in range(len(products_dict_list)):
    products_dict_categories = products_dict_list[k]
    products_list = products_dict_categories["products"]
    for m in range(len(products_list)):
        product_dict_item = products_list[m]
        product_dict_list.append(product_dict_item.copy())


#print(category_dict_list)
#print(product_dict_list)
#print(len(product_dict_list))


for i in range(len(product_dict_list)):
    product_item = product_dict_list[i]
    product_item_link_list = product_item["_links"]
    product_item_link_dict = product_item_link_list[0]
    product_item_link = product_item_link_dict["href"]

    product_item_href_full = product_item_link + href_suf

    #print(product_item_link)
    #print('\n')
    conn.request("GET", product_item_href_full)
    res4 = conn.getresponse()
    data_product_item = res4.read()
    data_product_item_string = data_product_item.decode("utf-8")

    products_dict_product_item = json.loads(data_product_item_string)
    products_list_product_item.append(products_dict_product_item.copy())
    #res4.close()
    conn.close()
    #print(products_list_product_item)



#print(products_list_product_item)

product_info_dict_list = []
list_del_key = ['descriptions', 'status', 'wellnessKeys', 'countryOfOrigin', 'disclaimer', 'isRaw', 'isMsgFree', 'isAntibioticFree', 'isCornFree', 'isLactoovoVegetarian',
                'isFairtrade','isIrradiated','isCertifiedHumane','isWildCaught','hasNoAddedHormones','averageSellableWeight','alcohol', 'diets','additives', 'allergens', 'ingredients',
                'nutrients', 'nutrition', 'organic', 'preparation', 'servings', 'tradeIdentifiers','states', '_links']
for i in range(len(products_list_product_item)):
    product_info_dict = dict(itertools.islice(products_list_product_item[i].items(), 4))

    # for del_key in list_del_key:
    #     products_list_product_item[i].pop(del_key)
    # product_info_dict = products_list_product_item[i]
    # #print(product_info_dict)

    if next(iter(product_info_dict)) != 'statusCode':
        product_info_dict.pop('descriptions')
        product_info_dict_list.append(product_info_dict.copy())
    '''
    for del_key in list_del_key:
        products_list_product_item[i].pop(del_key)
    product_info_dict = products_list_product_item[i]
    #print(product_info_dict)
    '''
    #print(type(product_info_dict))
    #print(product_info_dict)

    ##product_info_links_list = product_info_dict["_links"]

    ##for del_key in list_del_key:
    ##    product_info_dict.pop(del_key)
    ##product_info_dict_list.append(product_info_dict.copy())
print(product_info_dict_list)
##print(product_info_dict)




mydb = mysql.connect(host='localhost',    # your host_name
                       user='root',    # your username
                       passwd='3476269507',  # your password
                       db='wegmansdb'       # your database
                       )
cur= mydb.cursor()

for i in product_info_dict_list:
    values = []
    for k,v in i.items():
        values.append(v)
        print(values)
    insert_query = "INSERT INTO products(id ,product ,brand) VALUES (%s, %s, %s);"
    cur.execute(insert_query, values)
    mydb.commit()

# for k,v in product_info_dict_list.items():
#     values.append(v)


