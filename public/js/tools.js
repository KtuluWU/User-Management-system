// 常用的一些函数写在这个文件了

function Counter(array) {
    let count = {};
    array.forEach(val => count[val] = (count[val] || 0) + 1);
    return count;
}


function dateToYms(d) {
    let month = ('' + (d.getMonth() + 1)).padStart(2, '0');
    let day = ('' + d.getDate()).padStart(2, '0');
    let year = d.getFullYear();
    return [year, month, day].join('-');
}