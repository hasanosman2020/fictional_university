import $ from 'jquery';
class Search{
    //1. describe and create/initiate our object
    constructor(){
        this.openButton = document.querySelectorAll(".js-search-trigger"); 
        this.closeButton = document.querySelector(".search-overlay__close");
        this.searchOverlay = document.querySelector(".search-overlay");
        this.searchTerm = document.querySelector("#search-term");
        this.events();
        this.isOverlayOpen = false;
        this.typingTimer;
        this.resultsDiv = document.querySelector("#search-overlay__results");
        this.isSpinnerVisible = false;
        this.previousValue;
        this.getResults();




    }
    
    events(){
        this.openButton[0].addEventListener("click", this.openOverlay.bind(this));
        this.openButton[1].addEventListener("click", this.openOverlay.bind(this));
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this));
        window.addEventListener("keydown", this.keyPressHandler.bind(this));
        this.searchTerm.addEventListener("keyup", this.typingLogic.bind(this));

            }
//3. methods (function, action...)
typingLogic(){
    //console.log(e.keyCode)
    if(this.searchTerm.value != this.previousValue){
    clearTimeout(this.typingTimer);

    if(this.searchTerm.value){
        if(!this.isSpinnerVisible){
            this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
            this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000)
    } else {
        this.resultsDiv.innerHTML = '';
        this.isSpinnerVisible = false;
        
    }
    }
    this.previousValue = this.searchTerm.value;
}

getResults(){
    /*this.resultsDiv.innerHTML = "Imagine real search results here...";
this.isSpinnerVisible = false;*/
$.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchTerm.value, posts => {
    this.resultsDiv.innerHTML = `<h2>General Information</h2>

    ${posts.length ? '<ul class="link-list minn-list"></ul>' : '<p>There are no matches found for this search.</p>'
}
    ${posts.map(item =>`<li><a href="${item.link}">${item.title.rendered}
    </a>
    </li>`).join('')
}
   ${posts.length ? '</ul>' : '' }
   `}
);
}
keyPressHandler(e){
    //console.log(e.keyCode);
    if(e.keyCode == 83 && !this.isOverlayOpen && document.activeElement.tagName != 'INPUT'){
        this.openOverlay();
    }
    if(e.keyCode == 27 && this.isOverlayOpen){
        this.closeOverlay();
    }
}
openOverlay(){
    this.searchOverlay.classList.add("search-overlay--active");
    document.body.classList.add("body-no-scroll");
    console.log("open method just ran");
    this.isOverlayOpen = true;

}    

closeOverlay(){
    this.searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    console.log("close method just ran");
    this.isOverlayOpen = false;
}    
}
export default Search
