import React from 'react';
import ReactDOM from 'react-dom'
import "./frontend.scss";

//alert("This is the frontend of the plugin.");

const divsToUpdate = document.querySelectorAll(".paying--attention-update-me");

divsToUpdate.forEach(function (div) {
    ReactDOM.render(<Quiz />, div)
    div.classList.remove("paying-attention-update-me")
});

function Quiz() {
    return (
        <div className="paying-attention-frontend">
            Hello from React
        </div>
    )
}