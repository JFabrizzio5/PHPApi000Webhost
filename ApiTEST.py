import requests
import json

# URL de tu API para agregar registros
api_url_create = 'https://jos5web.000webhostapp.com/indexx.php'

# URL de tu API para la edición masiva
api_url_edit = 'https://jos5web.000webhostapp.com/indexx.php'

# Realizar una solicitud GET para obtener datos
def get_data():
    response = requests.get(api_url_create)
    if response.status_code == 200:
        data = response.json()
        for item in data:
            print(item)
    else:
        print("Error al obtener datos:", response.status_code)

# Realizar una solicitud POST para crear un nuevo registro
def create_data():
    id_usu = input("Ingrese Id_Usu: ")
    id_usu2 = input("Ingrese Id_Usu2: ")
    mensaje = input("Ingrese el mensaje: ")

    new_data = {
        "Id_Usu": id_usu,
        "Id_Usu2": id_usu2,
        "Mensaje": mensaje
    }
    headers = {'Content-Type': 'application/json'}
    response = requests.post(api_url_create, data=json.dumps(new_data), headers=headers)
    if response.status_code == 200:
        result = response.json()
        print(result)
    else:
        print("Error al crear nuevo registro:", response.status_code)

# Realizar una solicitud POST para editar registros de manera masiva
def edit_data():
    new_message = input("Ingrese el nuevo mensaje para la edición masiva: ")
    edit_data = {
        "mensaje_personalizado": new_message
    }
    headers = {'Content-Type': 'application/json'}
    response = requests.post(api_url_edit, data=json.dumps(edit_data), headers=headers)
    if response.status_code == 200:
        result = response.json()
        print(result)
    else:
        print("Error al editar registros:", response.status_code)

# Menú de selección de acción
while True:
    print("Selecciona una acción:")
    print("1. Realizar una operación GET")
    print("2. Realizar una operación POST para agregar registro")
    print("3. Realizar una operación POST para edición masiva")
    print("4. Salir")
    
    choice = input("Elije una opción (1/2/3/4): ")

    if choice == '1':
        get_data()
    elif choice == '2':
        create_data()
    elif choice == '3':
        edit_data()
    elif choice == '4':
        break
    else:
        print("Opción no válida. Por favor, elija una opción válida.")
