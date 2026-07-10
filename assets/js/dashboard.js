// Student Registration Chart

const studentChart = new Chart(document.getElementById('studentChart'),{

type:'line',

data:{

labels:['Jan','Feb','Mar','Apr','May','Jun'],

datasets:[{

label:'Students',

data:[120,180,260,310,420,500],

borderColor:'#4F46E5',

backgroundColor:'rgba(79,70,229,.15)',

fill:true,

tension:.4

}]

}

});

// Department Chart

const departmentChart = new Chart(document.getElementById('departmentChart'),{

type:'doughnut',

data:{

labels:['CSE','ECE','ME','CE'],

datasets:[{

data:[45,20,18,17],

backgroundColor:[

'#4F46E5',

'#06B6D4',

'#22C55E',

'#F59E0B'

]

}]

}

});