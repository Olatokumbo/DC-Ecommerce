from flask import Flask, Response, config, json
from flask_mysqldb import MySQL
from flask_caching import Cache
import json


app = Flask("__name__")
cache = Cache(
    config={"CACHE_TYPE": "RedisCache",
            "CACHE_REDIS_HOST": "redis-server",
            "CACHE_REDIS_PORT": 6379,
            "CACHE_DEFAULT_TIMEOUT": 30}
)

app.config["MYSQL_HOST"] = "mysql-app"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "admin123"
app.config["MYSQL_DB"] = "sys"
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'
# Redis setup
# app.config['CACHE_TYPE'] = "RedisCache"
# app.config['CACHE_REDIS_HOST'] = "redis-server"
# app.config['CACHE_REDIS_PORT'] =  6379
# app.config['CACHE_DEFAULT_TIMEOUT'] = 300

cache.init_app(app)
mysql = MySQL(app)


def default_json(t):
    return f'{t}'


@app.route("/ping", methods=["GET"])
def welcome():
    return "pong"


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


app.run(host="0.0.0.0", port="5001", debug=True)
