//MenuToggle
          let toggle = document.querySelector('.toggle');
          let navigation = document.querySelector('.navigation');
          let main = document.querySelector('.menu');
          let table = document.querySelector('.table');

        
          let currentTable = 1;

function Atras() {
    if (currentTable === 2) {
        const table1 = document.getElementById("table1");
        const table2 = document.getElementById("table2");

        table2.classList.add("moveLeft");
        table1.classList.remove("moveRight");

        table1.style.display = "block";
        table2.style.display = "none";
        currentTable = 1;
    } else if (currentTable === 3) {
        const table2 = document.getElementById("table2");
        const table3 = document.getElementById("table3");

        table3.classList.add("moveLeft");
        table2.classList.remove("moveRight");

        table2.style.display = "block";
        table3.style.display = "none";
        currentTable = 2;
    }
}

function Adelante() {
    if (currentTable === 1) {
        const table1 = document.getElementById("table1");
        const table2 = document.getElementById("table2");

        table1.classList.add("moveLeft");
        table2.classList.remove("moveRight");

        table1.style.display = "none";
        table2.style.display = "block";
        currentTable = 2;
    } else if (currentTable === 2) {
        const table2 = document.getElementById("table2");
        const table3 = document.getElementById("table3");

        table2.classList.add("moveLeft");
        table3.classList.remove("moveRight");

        table2.style.display = "none";
        table3.style.display = "block";
        currentTable = 3;
    }
}


          toggle.onclick = function(){
            navigation.classList.toggle('active')
            main.classList.toggle('active')
            table.classList.toggle('slide-in');
            table.classList.toggle('slide-out');
          }

    //add hover class in selected list item
          let list = document.querySelectorAll('.navigation li')
          function activeLink(){
            list.forEach((item) =>
              item.classList.remove('hovered'));
            this.classList.add('hovered');
          }
          list.forEach((item) =>
            item.addEventListener('mouseover',activeLink));


///////////////////////////////////////////////////////////////////////////////////
/////////////////Evita que los números se pasen de lo indicado////////////////////


