/*import $ from 'jquery';

class Like{
    constructor() {
        //alert('testing from Like');
        this.events();

    }
    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));

        
    }
    //methods go here
    ourClickDispatcher(e) {
        const currentLikeBox = $(e.target).closest(".like-box");
    
        if (currentLikeBox.attr("data-exists") == "yes") {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }
    

    createLike(currentLikeBox) {
        //alert("You created a new like.")
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLikes',
            type: 'POST',
            data: { 'professorId': currentLikeBox.data('professor') },
            success: (response) => {
                console.log(response)
                currentLikeBox.attr('data-exists', 'yes');
                let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount++;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr('data-like', response);




            },
            error: (response) => {
                console.log(response)
            }
        })
    }
    deleteLike(currentLikeBox) {
        //alert("You deleted a like.")
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLikes',
            data: {'like' : currentLikeBox.attr('data-like')},
            type: 'DELETE',
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no');
                let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
                likeCount--;
                currentLikeBox.find(".like-count").html(likeCount);
                currentLikeBox.attr('data-like', '');
                console.log(response)
            },
            error: (response) => {
                console.log(response)
            }
        })
    }

    }



export default Like;
*/


import axios from "axios";

class Like {
    constructor() {
        if (document.querySelector(".like-box")) {
            axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce;
            this.events();
        }

    }

    events() {
        document.querySelector(".like-box").addEventListener("click", e => this.ourClickDispatcher(e));
    };

    //methods
    ourClickDispatcher(e) {

        //const currentLikeBox = e.target.closest(".like-box");
        let currentLikeBox = e.target;
        while (!currentLikeBox.classList.contains("like-box")) {
            currentLikeBox = currentLikeBox.parentElement;
        }
        if (currentLikeBox.getAttribute("data-exists") == "yes") {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    };

    async createLike(currentLikeBox) {
        /*const response = fetch(universityData.root_url + "/wp-json/university/v1/manageLikes")
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.log(error));


        */
        try {
            const response = await axios.post(universityData.root_url + "/wp-json/university/v1/manageLikes", {
                "professorId": currentLikeBox.getAttribute("data-professor")
            });
    
            if (response.data !== "Only logged in users can create a like.") {
                currentLikeBox.setAttribute("data-exists", "yes");
                let likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10);
                likeCount++;
                currentLikeBox.querySelector(".like-count").innerHTML = likeCount;
                currentLikeBox.setAttribute("data-like", response.data);
            }
            console.log(response.data);
        } catch (e) {
            console.log("Sorry");
            //console.log("Sorry, you must be logged in to like a professor.");
        }
    }
    
    async deleteLike(currentLikeBox) {
        /*try {
            const response = fetch(universityData.root_url + "/wp-json/university/v1/manageLikes", {
                method: "delete", body: JSON.stringify({ "like": currentLikeBox.getAttribute("data-like") }
                )
            }, {
                body: JSON.stringify({ "like": currentLikeBox.setAttribute("data-exists", "no") })
            },
            
            );
*/

            
            try {
                const response = await axios({
                    url: universityData.root_url + "/wp-json/university/v1/manageLikes",
                    method: "delete",
                    data: {"like" : currentLikeBox.getAttribute("data-like")},
                })
                    currentLikeBox.setAttribute("data-exists", "no");
            let likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10);
            likeCount--;
            currentLikeBox.querySelector(".like-count").innerHTML = likeCount;
            currentLikeBox.setAttribute("data-like", "");
            
            console.log(response.data);
        } catch (e) {
            console.log(e);
            
        }

    }
}


export default Like
