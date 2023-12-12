import serial
import requests

def postApi(numero_gado):
    # URL da API para a qual você deseja enviar a requisição POST
    url = 'http://localhost:8000/api/predict'

    # Dados que você deseja enviar na requisição POST (um dicionário, por exemplo)
    dados = {
        "quantity": numero_gado,
        "local": "baracao",
        "user_email": "cupertinoangelo13@gmail.com"
    }

    # Cabeçalho indicando que você está enviando dados no formato JSON
    headers = {'Content-Type': 'application/json'}

    # Faz a requisição POST com o cabeçalho JSON
    response = requests.post(url, json=dados, headers=headers)

    # Verifica o código de status da resposta
    if response.status_code == 200:
        print('Requisição bem-sucedida!')
        print('Resposta da API:', response.json())  # Se a resposta for em JSON
    else:
        print('Erro na requisição. Código de status:', response.status_code)
        print('Conteúdo da resposta:', response.text)


# Configurações da porta serial
porta_serial = "COM7"  # Substitua pela porta serial correta
velocidade_serial = 115200

# Inicializa a comunicação serial
ser = serial.Serial(porta_serial, velocidade_serial, timeout=1)

# Variáveis para controle
contador_cows = 0

try:
    while True:
        # Lê uma linha da porta serial
        contador_cows = 0
        linha = ser.readline().decode('utf-8').rstrip()
        print(linha)
        if linha.startswith("Predictions"):
            while True:
                linha = ser.readline().decode('utf-8').rstrip().lstrip()
                if linha.startswith("cow"):
                    contador_cows += 1
                else:
                    break
            print("Cows encontradas:", contador_cows) # Da print na quantidade que foi contada
            postApi(contador_cows)

except KeyboardInterrupt:
    # Encerra a comunicação serial ao pressionar Ctrl+C
    ser.close()
    print("Comunicação serial encerrada.")

