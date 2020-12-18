const mysql = require('mysql');
const config = require('config');
const fs = require('fs');

//DB接続
exports.connect = () => {
    const con = mysql.createConnection(config.mysql)
    con.connect((err) => {
        if (err) throw err;
        console.log('connect success!');
    })
    return con;
}

//SQL ファイル読み込み
exports.importSQL = (filePath) => {
    if (fs.existsSync(filePath)) {
        //外部ファイル読み込み
        const sql = fs.readFileSync(filePath, 'utf-8');
        const con = this.connect();
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log(sql);
        });
        con.end();
    } else {
        console.log(`Not found ${filePath}`);
    }
}