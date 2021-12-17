FROM python:3.9-bullseye
    WORKDIR /app
    COPY . .
    RUN pip install flask
    RUN pip install flask_mysqldb
    ENV PORT=5000
    CMD ["python", "main.py"]