const http = require('http');
const https = require('https')

const hostname = '127.0.0.1';
const port = 3000;

// web server
const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/html');
  res.end('<h1>Hello World</h1>');
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});

// GET request
const get_options = {
  hostname: hostname, // 'whatever.com',
  port: port,         // 443,
  path: '/',          // '/todos',
  method: 'GET'
}

const get_req = https.request(get_options, res => {
  console.log(`statusCode: ${res.statusCode}`)

  res.on('data', d => {
    process.stdout.write(d)
  })
})

get_req.on('error', error => {
  console.error(error)
})

get_req.end()

// POST request
const data = JSON.stringify({
  todo: 'Buy the milk'
})

const post_options = {
  hostname: hostname, // 'whatever.com',
  port: port,         // 443,
  path: '/',          // '/todos',
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Content-Length': data.length
  }
}

const post_req = https.request(post_options, res => {
  console.log(`statusCode: ${res.statusCode}`)

  res.on('data', d => {
    process.stdout.write(d)
  })
})

post_req.on('error', error => {
  console.error(error)
})

post_req.write(data)
post_req.end()
