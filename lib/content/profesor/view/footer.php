
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
    //MenuToggle
      let toggle = document.querySelector('.toggle');
      let navigation = document.querySelector('.navigation');
      let main = document.querySelector('.main');

      toggle.onclick = function(){
        navigation.classList.toggle('active')
        main.classList.toggle('active')
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

        //Activar menus desplegables
        let desplegable = document.querySelector('.desplegable');
        desplegable.onclick = function(){
        desplegable.classList.toggle('active');
      }

      let desplegable2 = document.querySelector('.desplegable2');
        desplegable2.onclick = function(){
        desplegable2.classList.toggle('active');
      }
      </script>  

      
    </body>
    </html>