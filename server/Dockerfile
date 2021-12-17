FROM python:3.9-bullseye
    WORKDIR /app
    COPY . .
    RUN pip install flask
    RUN pip install flask_mysqldb
    RUN pip install Flask-Caching
    RUN pip install redis
    ENV PORT=5001
    CMD ["python", "main.py"]