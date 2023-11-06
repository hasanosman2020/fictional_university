import $ from 'jquery';
class Search{
    //1. describe and create/initiate our object
    constructor(){
        this.addSearchHTML();
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
        this.typingTimer = setTimeout(this.getResults.bind(this), 750)
    } else {
        this.resultsDiv.innerHTML = '';
        this.isSpinnerVisible = false;
        
    }
    }
    this.previousValue = this.searchTerm.value;
}

getResults(){
    $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchTerm.value, results => {
        this.resultsDiv.innerHTML = 
        `<div class="row">
        <div class="one-third">
        <h2 class="search-overlay__section-title">General Information</h2>
        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>There are no matches found for this search.</p>'
}
    ${results.generalInfo.map(item =>`<li><a href="${item.permalink}">${item.title}
    </a> ${item.postType == 'post' ? `by ${item.authorName}` : ' '};
    </li>`).join('')
}
   ${results.generalInfo.length ? '</ul>' : '' }
        </div>
        <div class="one-third">
        <h2 class="search-overlay__section-title">Programmes</h2>
        ${results.programmes.length ? '<ul class="link-list min-list">' : `<p>There are no programmes found for this search. <a href="${universityData.root_url}/programmes">View all programmes</a></p>`
}
    ${results.programmes.map(item =>`<li><a href="${item.permalink}">${item.title}
    </a> 
    </li>`).join('')
}
   ${results.programmes.length ? '</ul>' : '' }
        
        <h2 class="search-overlay__section-title">Professors</h2>
        ${results.professors.length ? '<ul class="professor-cards">' : '<p>There are no professors found for this search.</p>'
}
    ${results.professors.map(item =>`<li class="professor-card__list-item">
    <a class="professor-card" href="${item.permalink}">
    <img class="professor-card__image" src="${item.image}">
    <span class="professor-card__name">${item.title}</span>
</a>
</li>

  </li>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>`).join('')
}
   ${results.professors.length ? '</ul>' : '' }
        </div>
        <div class="one-third">
        <h2 class="search-overlay__section-title">Campuses</h2>
        ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>There are no campuses found for this search. <a href="${universityData.root_url}/campuses">View all campuses.</a></p>`
}
    ${results.campuses.map(item =>`<li><a href="${item.permalink}">${item.title}
    </a> 
    </li>`).join('')
}
   ${results.campuses.length ? '</ul>' : '' }
        <h2 class="search-overlay__section-title">Events</h2>
        </div>
        </div>`

    });
this.isSpinnerVisible = false;

};

    
    
    
    
    
    
    
    
    
    /*this.resultsDiv.innerHTML = "Imagine real search results here...";
this.isSpinnerVisible = false;*/

/*Initial built-in default wp API URL
$.when(
    $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchTerm.value),
    $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchTerm.value)
).then((posts, pages) => {
    var combinedResults = posts[0].concat(pages[0]);
    
    this.resultsDiv.innerHTML = `<h2>General Information</h2>

    ${combinedResults.length ? '<ul class="link-list min-list"></ul>' : '<p>There are no matches found for this search.</p>'
}
    ${combinedResults.map(item =>`<li><a href="${item.link}">${item.title.rendered}
    </a> ${item.type == 'post' ? `by ${item.authorName}` : ' '};
    </li>`).join('')
}
   ${combinedResults.length ? '</ul>' : '' }
   `},
   () => {
    this.resultsDiv.innerHTML = '<p>Unexpected error, please try again.</p>'
   }
   )
   this.isSpinnerVisible = false
}
*/
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
    this.searchTerm.value = '';
    setTimeout(() => this.searchTerm.focus(), 301);
    console.log("open method just ran");
    this.isOverlayOpen = true;

}    

closeOverlay(){
    this.searchOverlay.classList.remove("search-overlay--active");
    document.body.classList.remove("body-no-scroll");
    console.log("close method just ran");
    this.isOverlayOpen = false;
}    

addSearchHTML(){
    document.body.insertAdjacentHTML('beforeend', `<div class="search-overlay">
    <div class="search-overly__top">
<div class="container">
<i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
<input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" style="margin-top: 4rem;">
<i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
</div>
    </div>
    <div class="container">
      <div id="search-overlay__results"></div>
    </div>
  </div>`)
}
}
export default Search
