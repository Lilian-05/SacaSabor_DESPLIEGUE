@echo off
cd /d "C:\Users\lenovo\OneDrive\Desktop\Documentos\Default Project\sacasabor"
start "" php artisan serve --host=127.0.0.1 --port=8001
start "" http://127.0.0.1:8001
