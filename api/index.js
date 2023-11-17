const express = require('express');
const bodyParser = require('body-parser');

const app = express();
const port = 8000;

// Middleware para processar dados JSON
app.use(bodyParser.json());

// Rota de exemplo para lidar com uma requisição POST em /test
app.post('/test', (req, res) => {
  const postData = req.body;
  console.log('Received POST data:', postData);

  // Responder com uma mensagem simples
  res.json({ message: 'POST data received successfully!' });
});

// Iniciar o servidor
app.listen(port, () => {
  console.log(`Server is running at http://localhost:${port}`);
});
