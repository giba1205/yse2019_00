const db = require('./lib/db');

//db: connect()
const con = db.connect();

const password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
let posts = [ 
    { first_name: '田中', last_name: '一郎', email: 'tanaka@example.com', password: password, },
    { first_name: '佐藤', last_name: '二郎', email: 'satoh@example.com', password: password, },
    { first_name: '鈴木', last_name: '三郎', email: 'suzuki@example.com', password: password, },
    { first_name: '小林', last_name: '四郎', email: 'kobayashi@example.com', password: password, },
    { first_name: '伊藤', last_name: '五朗', email: 'itoh@example.com', password: password, },
]

let sql = 'INSERT INTO users SET ?;';
posts.forEach((post) => {
    con.query(sql, post, (err, results) => {
        if (err) console.log(err.sqlMessage);
        console.log('insert success.');
    })
})

con.end();