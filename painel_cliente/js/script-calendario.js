// variaveis globais
let nav = 0
let clicked = null
let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')) : []


// variavel do modal:

const calendar = document.getElementById('calendar') // div calendar:
const weekdays = ['domingo','segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'] //array with weekdays:

//funções
function clicou(data){
  //alert(data)
  document.getElementById('data_selecionada').value = data;
  buscar();
}

//função load() será chamada quando a pagina carregar:

function load (){ 

  const date = new Date() 

  const data_sel = document.getElementById('data_selecionada').value;
  
  //pegar o dia da data selecionada
  const split = data_sel.split('-');
  const data_selec = split[2];
  

  //mudar titulo do mês:
  if(nav !== 0){
    date.setMonth(new Date().getMonth() + nav) 
  }
  
  const day = date.getDate()
  const month = date.getMonth()
  const year = date.getFullYear()

 

  const array_datas = document.getElementById('array_datas');

  
  const daysMonth = new Date (year, month + 1 , 0).getDate()
  const firstDayMonth = new Date (year, month, 1)
  

  const dateString = firstDayMonth.toLocaleDateString('pt-br', {
    weekday: 'long',
    year:    'numeric',
    month:   'numeric',
    day:     'numeric',
  })
  

  const paddinDays = weekdays.indexOf(dateString.split(', ') [0])

  //mostrar mês e ano:
  document.getElementById('monthDisplay').innerText = `${date.toLocaleDateString('pt-br',{month: 'short'})} ${year}`

  
  calendar.innerHTML =''



  // criando uma div com os dias:

  for (let i = 1; i <= paddinDays + daysMonth; i++) {
    const dayS = document.createElement('div')
    dayS.classList.add('day')

    const dayString = `${month + 1}/${i - paddinDays}/${year}`
    const dayStringAm = `${year}-${month + 1}-${i - paddinDays}`


    
    var dia = i - paddinDays;
    if(dia < 10){
      dia = '0'+dia;
    }else{
      dia = dia+'';
    }

     var mes_n = month + 1;
    if(mes_n < 10){
      mes_n = '0'+mes_n;
    }else{
      mes_n = mes_n+'';
    }

    const dataBd = year + '-' + mes_n + '-' + dia;


      if(i - paddinDays < day && nav === 0){
        dayS.id = 'diasPassados'
      }         

   
    //verificar no array se a data do input existe
      if(array_datas.value.indexOf(dataBd) != -1){          
          dayS.id = 'diaOcupado';
      }else{
         //dayS.id = 'diaLivre';
      }
      
         
    //condicional para criar os dias de um mês:
     
    if (i > paddinDays) {
      dayS.innerText = i - paddinDays
      

      const eventDay = events.find(event=>event.date === dayString)
      
     

      if(dia.trim() === data_selec.trim() && nav === 0){        
        dayS.id = 'currentDay'
      } 


     
      dayS.addEventListener('click', ()=> clicou(dataBd))

    } else {
      dayS.classList.add('padding')
    }

    
    calendar.appendChild(dayS)
  }
}






// botões 

function buttons (){
  document.getElementById('backButton').addEventListener('click', ()=>{
    nav--
    load()
    
  })

  document.getElementById('nextButton').addEventListener('click',()=>{
    nav++
    load()
    
  })

  
  
}
buttons()
load()

