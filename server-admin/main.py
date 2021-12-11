from flask import Flask, Response, json, request
from flask_mysqldb import MySQL
import json

app = Flask("__name__")

# MySQL Configuration
app.config["MYSQL_HOST"] = "mysql-app"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "admin123"
app.config["MYSQL_DB"] = "sys"
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

mysql = MySQL(app)


def default_json(t):
    return f'{t}'


@app.route("/ping", methods=["GET"])
def welcome():
    return "pong"


# Get All Products
@app.route("/", methods=["GET"])
def main():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM products")
    data = cur.fetchall()
    return Response(json.dumps(data, default=default_json),  mimetype='application/json')

# Add New Product
@app.route("/add", methods=['GET', 'POST'])
def main1():
    name = request.args.get("name")
    price = request.args.get("price")
    quantity = request.args.get("quantity")
    if request.method == "GET":
        return Response(json.dumps({"message": "done"}, default=default_json),  mimetype='application/json')
    if request.method == "POST":
        cur = mysql.connection.cursor()
        cur.execute("INSERT INTO products(name, price, quantity) VALUE(%s, %s, %s)",
                    ([name], price, quantity))
        mysql.connection.commit()
        cur.close()
        return "Done"
    else:
        return name


# Edit Product
@app.route("/product/<productId>/edit", methods=['POST', 'GET'])
def edit(productId):
    name = request.args.get("name")
    price = request.args.get("price")
    quantity = request.args.get("quantity")
    print(name);
    if request.method == "POST":
        cur = mysql.connection.cursor()
        cur.execute("UPDATE products SET name=%s, price=%s, quantity=%s WHERE id=%s",
                    ([name], price, quantity, [productId]))
        mysql.connection.commit()
        cur.close()
    if request.method == "GET":
        cur = mysql.connection.cursor()
        cur.execute("SELECT * FROM products WHERE id=%s", ([productId]))
        data = cur.fetchall()
        return Response(json.dumps(data, default=default_json),  mimetype='application/json')
    
    return "Done"


# Delete Product
@app.route("/product/<productId>/delete", methods=["POST"])
def delete(productId):
    if request.method == "POST":
        cur = mysql.connection.cursor()
        cur.execute("DELETE FROM products WHERE id=%s", ([productId]))
        mysql.connection.commit()
        cur.close()
    return "Done"


app.run(host="0.0.0.0", port="5000", debug=True)
