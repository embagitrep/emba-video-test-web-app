
function findPara(param){
    let result = '';
    process.argv.forEach((argv)=>{
        if(argv.indexOf('--' + param) === -1) return;
        result = argv.split('=')[1];
    });
    return  result;
}

module.exports = () =>{
    return process.env.NODE_ENV
}
