//load modules
const mysql = require('mysql');
const config = require('config');

//create MySQL connection 
const con = mysql.createConnection({
host: 'localhost',
port: '3306',
user: 'root',
password: '',
});

//connect to MySQL 
con.connect((err) => {
if (err) throw err;
console.log('connect success!');
});

//create SQL 
const sql = 'CREATE DATABASE ' + config.mysql.database;
console.log(sql);

//exec SQL
con.query(sql,(err)=>{
    if (err) throw err;
    console.log('created database.');
})

//end connection
con.end();