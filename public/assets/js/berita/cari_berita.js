function search_news() {
    let input = document.getElementById('searchbar').value
    input=input.toLowerCase();
    let x = document.getElementsByClassName('news-title');
    let y = document.getElementsByClassName('news-portal');
    
    let v = document.getElementsByClassName('div-gambar');
    for (i = 0; i < x.length; i++) { 
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            v[i].style.display="none"; 
            x[i].style.display="none";
            y[i].style.display="none";
            
        }
        else {
            v[i].style.display="inherit"; 
            x[i].style.display="inherit";  
            y[i].style.display="inherit";
                 
        }
    }
}