class Search{
    //1. describe and create/initiate our object
    constructor(){
        this.openButton = document.querySelectorAll(".js-search-trigger"); 
        this.closeButton = document.querySelector(".search-overlay__close");
        this.searchOverlay = document.querySelector(".search-overlay");
        this.events();
    }
    
    events(){
        this.openButton[0].addEventListener("click", this.openOverlay.bind(this));
        this.openButton[1].addEventListener("click", this.openOverlay.bind(this));
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this));
            }
//3. methods (function, action...)
openOverlay(){
    this.searchOverlay.classList.add("search-overlay--active");
}

closeOverlay(){
    this.searchOverlay.classList.remove("search-overlay--active");
}
} 

    export default Search;
