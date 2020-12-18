const db = require('./lib/db');

const con = db.connect();

const sql = 'UPDATE users SET email = ? WHERE id = ?';
const email = '190162dj@yse-c.net';
const id = 1;
let params = [email, id];

con.query(sql,params,(err, results) => {
    if (err) throw err;
    console.log(results);
    console.log('update success!!');
})

con.end();