class Search{
    //1. describe and create/initiate our object
    constructor(){
        this.openButton = document.querySelectorAll(".js-search-trigger"); 
        this.closeButton = document.querySelector(".search-overlay__close");
        this.searchOverlay = document.querySelector(".search-overlay");
        this.events();
        this.isOverlayOpen = false;

    }
    
    events(){
        this.openButton[0].addEventListener("click", this.openOverlay.bind(this));
        this.openButton[1].addEventListener("click", this.openOverlay.bind(this));
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this));
        window.addEventListener("keydown", this.keyPressHandler.bind(this));

            }
//3. methods (function, action...)
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
keyPressHandler(e){
    //console.log(e.keyCode);
    if(e.keyCode == 83 && !this.isOverlayOpen){
        this.openOverlay();
        

    }
    if(e.keyCode == 27 && this.isOverlayOpen){
        this.closeOverlay();



    }
}
} 

    export default Search;
