var search_bar = document.getElementById("searchBar");
 searchInput.addEventListener('keyup',function(event){
     let searchQuery = event.target.value.toLowerCase();

     console.log(searchQuery)
     let product  = document.getElementsByClassName('product')
     let nom  = document.getElementsByClassName('name')
     
     for(let i=0;i<nom.length;i++){
         const currentName = nom[i].textContent.toLowerCase();

         if(currentName.includes(searchQuery))  
         {
       
            let product  = document.getElementsByClassName('product')[i].style.display = 'block';
         }   
         else{
         
             product[i].style.display = 'none';
         }
 
     }
 })