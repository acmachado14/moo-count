import serial

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
        if linha.startswith("Predictions"):
            while True:
                linha = ser.readline().decode('utf-8').rstrip().lstrip()
                if linha.startswith("cow"):
                    contador_cows += 1
                else:
                    break
            print("Cows encontradas:", contador_cows) # Da print na quantidade que foi contada

except KeyboardInterrupt:
    # Encerra a comunicação serial ao pressionar Ctrl+C
    ser.close()
    print("Comunicação serial encerrada.")

