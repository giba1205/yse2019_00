const db = require('./lib/db');

const con = db.connect();

let sql ='';
sql ='SELECT * FROM users';



con.query(sql, (error, results) => {
    if (err) throw err;
    results.forEach((user) => {
        console.log(user.id);
        console.log(user.email);
    })
});



sql = 'SELECT * FROM users WHERE ?';
let params ={}
params = { id: 3} 

con.query(sql, params, (err, results) => {
    if (err) throw err;
        let user = results[0];
        console.log(`${user.first_name}  ${user.later_name}`);
   
});


sql = 'SELECT * FROM users WHERE  LIMIT ? OFFSET ?';
const limit = 3;
const offset = 0;
params = [limit, offset]

con.query(sql, params, (err, results) => {
    if (err) throw err;
        results.forEach((user) => {
            console.log(user.email);
        })
     
});


con.end();