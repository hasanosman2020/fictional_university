//alert ("Hello from test.js!");
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    edit: function () {
        //wp.element.createElement("h3", null, "Hello from the editor - this is h3!");
        return (
            <div>
                <p>Hello - this is a paragraph from JSX.</p>
                <h2>Hello there - this is h2 from JSK.</h2>
            </div>
        )
        
    },
    save: function () {
        wp.element.createElement("h1", null, "Hello from the frontend - this is h1!");

        
    }
} );

