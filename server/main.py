from flask import Flask, Response, json, request
from flask_mysqldb import MySQL
from flask_caching import Cache
import json


app = Flask("__name__")

# Initialize Flask caching
cache = Cache(
    config={
        "CACHE_TYPE": "RedisCache",
        "CACHE_REDIS_HOST": "redis-server",
        "CACHE_REDIS_PORT": 6379,
        "CACHE_DEFAULT_TIMEOUT": 30  # Cache duration
    }
)

# MySQL Configuration
app.config["MYSQL_HOST"] = "mysql-app"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "admin123"
app.config["MYSQL_DB"] = "sys"
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

cache.init_app(app)
mysql = MySQL(app)


def default_json(t):
    return f'{t}'


@app.route("/ping", methods=["GET"])
def welcome():
    return "pong"


# Get All Products
@app.route("/", methods=["GET"])
def main():
    cachedData = cache.get("data")
    if cachedData:
        return Response(json.dumps(cachedData, default=default_json),  mimetype='application/json')
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM products")
    data = cur.fetchall()
    print(data)
    cache.set("data", data)
    return Response(json.dumps(data, default=default_json),  mimetype='application/json')


@app.route("/search", methods=["GET", "POST"])
def search():
    name = request.args.get("name")
    cachedData = cache.get(name)
    if cachedData:
        return Response(json.dumps(cachedData, default=default_json),  mimetype='application/json')

    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM products WHERE LOWER(name) LIKE LOWER(%s)",
                (["%" + name+"%"]))
    data = cur.fetchall()
    if data:
        cache.set(name, data)
    return Response(json.dumps(data, default=default_json),  mimetype='application/json')


app.run(host="0.0.0.0", port="5001", debug=True)
