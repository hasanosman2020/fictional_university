import $ from 'jquery';

class MyNotes {
    constructor() {
        // jQuery selectors
        this.events();
    }

    events() {
        /* jQuery
        when the user clicks on the delete button, the deleteNote method will run*/
        $(".delete-note").on("click", this.deleteNote);
        //when the user clicks on the edit button, the editNote method will run
        $(".edit-note").on("click", this.editNote.bind(this));

    }
    
    //Methods will go here
    /* jQuery
    e is the event object, and we can use it to get the element that was clicked on - e.target contains information about the element that was clicked on and we look for the closest li element to that element which is the note that we want to delete. */
    deleteNote(e) {
        let thisNote = $(e.target).parents("li");

        $.ajax({
            //before the delete operation is performed, we want to send a request to the server to make sure that the user is logged in and that they have the permission to delete the note - we create a new property called beforeSend and we pass it a function that will run before the delete opoeration is performed - we pass it the xhr object which is the object that is used to make the request to the server - we add the X-WP-Nonce header to the request and we pass it the nonce that we created in the functions.php file - this will make sure that the user is logged in and that they have the permission to delete the note*/
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            // send to the rooturl and the rest api endpoint and we pass it the id of the note that we want to delete
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (response) => {
                thisNote.slideUp();
                console.log("Congrats");
                console.log(response);

            },
            error: (response) => {
                console.log("Error");
                console.log(response);

            }
        })
    }

    editNote(e) {
        let thisNote = $(e.target).parents("li")

        //if the note is editable we want to make it readonly
        if (thisNote.data("state") == "editable") {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }
    }

    makeNoteEditable(thisNote) {
        //find the edit button and change it to cancel
        thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        //find the title field and body field and remove the readonly attribute and add the note-active-field class which will add a border to the field and make it look like it is active
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active--field");
        //find the save button which has a class of update-note and add the update-note--visible class which will make the button visible
        thisNote.find(".update-note").addClass("update-note--visible");
        //add a data-state attribute to the note and set it to editable because of the if statement above
        thisNote.data("state", "editable");

    }

    makeNoteReadOnly(thisNote) {
        //find the edit button which will now say cancel and change it back to edit
        thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        //find the title field and body field and add the readonly attribute and remove the note-active-field class which will remove the border from the field and make it look like it is not active
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        //find the save button which has a class of update-note and remove the update-note--visible class which will make the button invisible
        thisNote.find(".update-note").removeClass("update-note--visible");
        //add a data-state attribute to the note and set it to cancel or false because of the if statement above
        thisNote.data("state", "cancel");

    }
}
export default MyNotes;









/*
class MyNotes {
    constructor() {

        // alert("New note created.")
        this.deleteBtn = document.querySelectorAll('.delete-note');
        this.editBtn = document.querySelectorAll('.edit-note');
        
        this.events();
    }

    events() {
        this.deleteBtn.forEach(btn => btn.addEventListener('click', this.deleteNote));
        this.editBtn.forEach(btn => btn.addEventListener('click', this.editNote));
    }

    //Methods will go here
    deleteNote(e) {
        //alert("You clicked the delete button.");
        const thisNote = e.target.closest('li');
        console.log(thisNote);

        fetch(universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.dataset.id,
            {
                method: 'DELETE',
                headers: {
                    'X-WP-Nonce': universityData.nonce,
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw Error(response.statusText);
                } else {
                    thisNote.remove(thisNote);
                    return response.json();
                    

                }
            })
            .catch(error => console.log(error));
    }

    editNote(e) {
        let thisNote = e.target.closest('li');

        if (thisNote.dataset.state == 'editable') {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }
    }

    makeNoteEditable(thisNote) {
        thisNote.dataset.state = 'editable';
        thisNote.querySelector('.edit-note').innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>Cancel';
        thisNote.querySelector('.note-title-field').removeAttribute('readonly');

    }
/*
    editNote = (e) => {
        const note = e.target.closest('li');
 
        if (note.dataset.status == "editable") {
            this.makeReadOnly(note);
        } else {
            this.makeEditable(note);
        }
    };
 
    makeEditable = (target) => {
        //changes note status to editable
        target.dataset.status = "editable";
 
        //unlock all inputs
        const inputs = target.querySelectorAll('input, textarea');
        inputs.forEach(el => {
            el.readOnly = false;
            el.classList.add('note-active-field');
        });
 
        //saves old values for current note
        const title = target.querySelector('input').value;
        const body = target.querySelector('textarea').value;
        this.noteValues[target.dataset.id] = { title: title, content: body };
 
        //transform edit button
        target.querySelector('.update-note').classList.add('update-note--visible');
        target.querySelector('.edit-note').innerHTML = `< class="fa fa-times" aria-hidden="true"></i>Cancel`;
    };
 
    makeReadOnly = (target) => {
        //changes note status to not editable
        target.dataset.status = false;
 
        //lock all inputs
        const inputs = target.querySelectorAll('input, textarea');
        inputs.forEach(el => {
            el.readOnly = true;
            el.classList.remove('note-active-field');
        });
 
        //Restore old values for current note
        target.querySelector('input').value = this.noteValues[target.dataset.id].title;
        target.querySelector('textarea').value = this.noteValues[target.dataset.id].content;
 
        //transform cancel button
        target.querySelector('.update-note').classList.remove('update-note--visible');
        target.querySelector('.edit-note').innerHTML = '<i class="fa fa-pencil" aria-hidden="true">Edit</i>';
    };
 
    /*
    editNote = (e) => {
        //alert("You clicked the edit button.")
        const thisNote = e.target.closest('li');
        
        if (thisNote.getAttribute('data-state') == 'editable') {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }
    }
    
        makeNoteEditable(thisNote) {
            thisNote.setAttribute('data-state', 'editable');
            thisNote.querySelector('.edit-note').innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>Cancel';
            thisNote.querySelector('.note-title-field').removeAttribute('readonly');
            thisNote.querySelector('.note-body-field').removeAttribute('readonly');
            thisNote.querySelector('.upodate-note').classList.add('update-note--visible');
            thisNote.querySelector('.note-title-field').classList.add('note-active-field');
            thisNote.querySelector('.note-body-field').classList.add('note-active-field');

        }

        makeNoteReadOnly(thisNote) {
            thisNote.setAttribute('data-state', 'cancel');
            thisNote.querySelector('.edit-note').innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i>Edit';
            thisNote.querySelector('.note-title-field').setAttribute('readonly', 'readonly');
            thisNote.querySelector('.note-body-field').setAttribute('readonly', 'readonly');
            thisNote.querySelector('.update-note').classList.remove('update-note--visible');
            thisNote.querySelector('.note-title-field').classList.remove('note-active-field');
            thisNote.querySelector('.note-body-field').classList.remove('note-active-field');

        }
    }
/*
        fetch(universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.dataset.id, {
            method: "POST",
            headers: {
                'X-WP-Nonce': universityData.nonce,
                'Content-Type': 'application/json',
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw Error(response.statusText);
                    console.log('Error');
                } else {
                    this.titleField.removeAttr(readonly);
                    this.contentField.removeAttr(readonly);
                    this.editBtn.classList.toggle('edit-note--visible');
                    this.titleField.classList.add('note-active-field');
                    this.contentField.classList.add('note-active-field');
                }
            })
        .catch(error => console.log(error));

            }
        }
}
export default MyNotes;
*/