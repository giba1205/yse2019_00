//load modules
const mysql = require('mysql');
//const config = require('config');

//create MySQL connection 
const con = mysql.createConnection({
host: 'localhost',
user: 'root',
port: '3306',
password: '',
});

//connect to MySQL 
con.connect((err) => {
if (err) throw err;
console.log('connect success!');
})

//end connection
con.end();